<?php

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3;

use DOMDocument;
use Exception;
use Pronamic\WordPress\Pay\Core\Util as Core_Util;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML\AcquirerErrorResMessage;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML\AcquirerStatusReqMessage;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML\AcquirerStatusResMessage;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML\DirectoryRequestMessage;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML\DirectoryResponseMessage;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML\Message;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML\RequestMessage;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML\ResponseMessage;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML\TransactionRequestMessage;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML\TransactionResponseMessage;
use SimpleXMLElement;
use WP_Error;
use XMLSecurityDSig;
use XMLSecurityKey;

/**
 * Title: iDEAL client
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 * @since   1.0.0
 */
class Client {
	/**
	 * Acquirer URL
	 *
	 * @var string
	 */
	public $acquirer_url;

	/**
	 * Directory request URL
	 *
	 * @var string
	 */
	public $directory_request_url;

	/**
	 * Transaction request URL
	 *
	 * @var string
	 */
	public $transaction_request_url;

	/**
	 * Status request URL
	 *
	 * @var string
	 */
	public $status_request_url;

	/**
	 * Merchant ID
	 *
	 * @var string
	 */
	public $merchant_id;

	/**
	 * Sub ID
	 *
	 * @var string
	 */
	public $sub_id;

	/**
	 * Private certificate
	 *
	 * @var string
	 */
	public $private_certificate;

	/**
	 * Private key
	 *
	 * @var string
	 */
	public $private_key;

	/**
	 * Private key password
	 *
	 * @var string
	 */
	public $private_key_password;

	/**
	 * Error
	 *
	 * @var WP_Error
	 */
	private $error;

	/**
	 * Constructs and initialzies an iDEAL Advanced v3 client object
	 */
	public function __construct() {

	}

	/**
	 * Get the latest error
	 *
	 * @return WP_Error or null
	 */
	public function get_error() {
		return $this->error;
	}

	/**
	 * Set the acquirer URL
	 *
	 * @param string $url
	 */
	public function set_acquirer_url( $url ) {
		$this->acquirer_url = $url;

		$this->directory_request_url   = $url;
		$this->transaction_request_url = $url;
		$this->status_request_url      = $url;
	}

	/**
	 * Send an specific request message to an specific URL
	 *
	 * @param string         $url
	 * @param RequestMessage $message
	 *
	 * @return ResponseMessage
	 */
	private function send_message( $url, RequestMessage $message ) {
		$result = false;

		// Sign
		$document = $message->get_document();
		$document = $this->sign_document( $document );

		if ( false !== $document ) {
			// Stringify
			$data = $document->saveXML();

			/*
			 * Fix for a incorrect implementation at https://www.ideal-checkout.nl/simulator/.
			 *
			 * @since 1.1.11
			 */
			if ( 'https://www.ideal-checkout.nl/simulator/' === $url ) {
				$data = $document->C14N( true, false );
			}

			// Remote post
			$response = wp_remote_post( $url, array(
				'method'  => 'POST',
				'headers' => array(
					'Content-Type' => 'text/xml; charset=' . Message::XML_ENCODING,
				),
				'body'    => $data,
			) );

			// Handle response
			if ( ! is_wp_error( $response ) ) {
				if ( 200 === wp_remote_retrieve_response_code( $response ) ) {
					$body = wp_remote_retrieve_body( $response );

					$xml = Core_Util::simplexml_load_string( $body );

					if ( is_wp_error( $xml ) ) {
						$this->error = $xml;
					} else {
						$document = self::parse_document( $xml );

						if ( is_wp_error( $document ) ) {
							$this->error = $document;
						} else {
							$result = $document;
						}
					}
				} else {
					$this->error = new WP_Error(
						'wrong_response_code',
						sprintf(
							/* translators: %s: response code */
							__( 'The response code (<code>%s<code>) from the iDEAL provider was incorrect.', 'pronamic_ideal' ),
							wp_remote_retrieve_response_code( $response )
						)
					);
				}
			} else {
				$this->error = $response;
			}
		}

		return $result;
	}

	/**
	 * Parse the specified document and return parsed result
	 *
	 * @param SimpleXMLElement $document
	 *
	 * @return ResponseMessage|WP_Error
	 */
	private function parse_document( SimpleXMLElement $document ) {
		$this->error = null;

		$name = $document->getName();

		switch ( $name ) {
			case AcquirerErrorResMessage::NAME:
				$message = AcquirerErrorResMessage::parse( $document );

				$this->error = new WP_Error(
					'IDealAdvancedV3_error',
					sprintf( '%s. %s', $message->error->get_message(), $message->error->get_detail() ),
					$message->error
				);

				return $message;
			case DirectoryResponseMessage::NAME:
				return DirectoryResponseMessage::parse( $document );
			case TransactionResponseMessage::NAME:
				return TransactionResponseMessage::parse( $document );
			case AcquirerStatusResMessage::NAME:
				return AcquirerStatusResMessage::parse( $document );
			default:
				return new WP_Error(
					'IDealAdvancedV3_error',
					/* translators: %s: XML document element name */
					sprintf( __( 'Unknwon iDEAL message (%s)', 'pronamic_ideal' ), $name )
				);
		}
	}

	/**
	 * Get directory of issuers
	 *
	 * @return Directory
	 */
	public function get_directory() {
		$directory = false;

		$request_dir_message = new DirectoryRequestMessage();

		$merchant = $request_dir_message->get_merchant();
		$merchant->set_id( $this->merchant_id );
		$merchant->set_sub_id( $this->sub_id );

		$response_dir_message = $this->send_message( $this->directory_request_url, $request_dir_message );

		if ( $response_dir_message instanceof DirectoryResponseMessage ) {
			$directory = $response_dir_message->get_directory();
		}

		return $directory;
	}

	/**
	 * Create transaction
	 *
	 * @param Transaction $transaction
	 * @param string      $issuer_id
	 *
	 * @return TransactionResponseMessage
	 */
	public function create_transaction( Transaction $transaction, $return_url, $issuer_id ) {
		$message = new TransactionRequestMessage();

		$merchant = $message->get_merchant();
		$merchant->set_id( $this->merchant_id );
		$merchant->set_sub_id( $this->sub_id );
		$merchant->set_return_url( $return_url );

		$message->issuer = new Issuer();
		$message->issuer->set_id( $issuer_id );

		$message->transaction = $transaction;

		return $this->send_message( $this->transaction_request_url, $message );
	}

	/**
	 * Get the status of the specified transaction ID
	 *
	 * @param string $transaction_id
	 *
	 * @return TransactionResponseMessage
	 */
	public function get_status( $transaction_id ) {
		$message = new AcquirerStatusReqMessage();

		$merchant = $message->get_merchant();
		$merchant->set_id( $this->merchant_id );
		$merchant->set_sub_id( $this->sub_id );

		$message->transaction = new Transaction();
		$message->transaction->set_id( $transaction_id );

		return $this->send_message( $this->status_request_url, $message );
	}

	/**
	 * Sign the specified DOMDocument
	 *
	 * @link https://github.com/Maks3w/xmlseclibs/blob/v1.3.0/tests/xml-sign.phpt
	 *
	 * @param DOMDocument $document
	 *
	 * @return DOMDocument
	 */
	private function sign_document( DOMDocument $document ) {
		$result = false;

		try {
			$dsig = new XMLSecurityDSig();

			// For canonicalization purposes the exclusive (9) algorithm must be used.
			// @link http://pronamic.nl/wp-content/uploads/2012/12/iDEAL-Merchant-Integration-Guide-ENG-v3.3.1.pdf #page 30
			$dsig->setCanonicalMethod( XMLSecurityDSig::EXC_C14N );

			// For hashing purposes the SHA-256 (11) algorithm must be used.
			// @link http://pronamic.nl/wp-content/uploads/2012/12/iDEAL-Merchant-Integration-Guide-ENG-v3.3.1.pdf #page 30
			$dsig->addReference(
				$document,
				XMLSecurityDSig::SHA256,
				array( 'http://www.w3.org/2000/09/xmldsig#enveloped-signature' ),
				array(
					'force_uri' => true,
				)
			);

			// For signature purposes the RSAWithSHA 256 (12) algorithm must be used.
			// @link http://pronamic.nl/wp-content/uploads/2012/12/iDEAL-Merchant-Integration-Guide-ENG-v3.3.1.pdf #page 31
			$key = new XMLSecurityKey( XMLSecurityKey::RSA_SHA256, array(
				'type' => 'private',
			) );

			$key->passphrase = $this->private_key_password;

			$key->loadKey( $this->private_key );

			// Test if we can get an private key object, to prefent the following errors:
			// Warning: openssl_sign() [function.openssl-sign]: supplied key param cannot be coerced into a private key
			$result = openssl_get_privatekey( $this->private_key, $this->private_key_password );

			if ( false !== $result ) {
				// Sign
				$dsig->sign( $key );

				// The public key must be referenced using a fingerprint of an X.509
				// certificate. The fingerprint must be calculated according
				// to the following formula HEX(SHA-1(DER certificate)) (13)
				// @link http://pronamic.nl/wp-content/uploads/2012/12/iDEAL-Merchant-Integration-Guide-ENG-v3.3.1.pdf #page 31
				$fingerprint = Security::get_sha_fingerprint( $this->private_certificate );

				$dsig->addKeyInfoAndName( $fingerprint );

				// Add the signature
				$dsig->appendSignature( $document->documentElement );

				$result = $document;
			} else {
				throw new Exception( 'Can not load private key' );
			}
		} catch ( Exception $e ) {
			$this->error = new WP_Error( 'xml_security', $e->getMessage(), $e );
		}

		return $result;
	}
}
