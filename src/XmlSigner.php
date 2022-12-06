<?php
/**
 * XML Signer.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3;

use DOMDocument;
use DOMElement;
use OpenSSLAsymmetricKey;

/**
 * XML Signer class
 */
class XmlSigner {
	/**
	 * Key name.
	 * 
	 * @var string
	 */
	private $key_name;

	/**
	 * Private key.
	 * 
	 * @var OpenSSLAsymmetricKey
	 */
	private $private_key;

	/**
	 * Construct XML signer.
	 * 
	 * @param string               $key_name    Key name.
	 * @param OpenSSLAsymmetricKey $private_key Private key.
	 */
	public function __construct( string $key_name, OpenSSLAsymmetricKey $private_key ) {
		$this->key_name = $key_name;

		$this->private_key = $private_key;
	}

	/**
	 * Get element with signed info.
	 * 
	 * @param DOMDocument $document Document.
	 * @param string      $digest_value Digest value.
	 * @return DOMElement
	 */
	private function get_element_signed_info( DOMDocument $document, string $digest_value ): DOMElement {
		$element_signed_info = $document->createElement( 'SignedInfo' );

		$element_canonicalization_method = $document->createElement( 'CanonicalizationMethod' );
		$element_canonicalization_method->setAttribute( 'Algorithm', 'http://www.w3.org/2001/10/xml-exc-c14n#' );

		$element_signed_info->appendChild( $element_canonicalization_method );

		$element_signature_method = $document->createElement( 'SignatureMethod' );
		$element_signature_method->setAttribute( 'Algorithm', 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256' );

		$element_signed_info->appendChild( $element_signature_method );

		$element_reference = $document->createElement( 'Reference' );
		$element_reference->setAttribute( 'URI', '' );

		$element_signed_info->appendChild( $element_reference );

		$element_transforms = $document->createElement( 'Transforms' );

		$element_reference->appendChild( $element_transforms );

		$element_transform = $document->createElement( 'Transform' );
		$element_transform->setAttribute( 'Algorithm', 'http://www.w3.org/2000/09/xmldsig#enveloped-signature' );

		$element_transforms->appendChild( $element_transform );

		$element_digest_method = $document->createElement( 'DigestMethod' );
		$element_digest_method->setAttribute( 'Algorithm', 'http://www.w3.org/2001/04/xmlenc#sha256' );

		$element_reference->appendChild( $element_digest_method );

		$element_digest_value = $document->createElement( 'DigestValue', $digest_value );

		$element_reference->appendChild( $element_digest_value );

		return $element_signed_info;
	}

	/**
	 * Get element with key info.
	 * 
	 * @param DOMDocument $document Document.
	 * @param string      $key_name Key name.
	 * @return DOMElement
	 */
	private function get_element_key_info( $document, $key_name ): DOMElement {
		$element_key_info = $document->createElement( 'KeyInfo' );

		$element_key_name = $document->createElement( 'KeyName', $key_name );

		$element_key_info->appendChild( $element_key_name );

		return $element_key_info;
	}

	/**
	 * Sign document.
	 * 
	 * @param DOMDocument $document Document to sign.
	 * @return DOMDocument
	 * @throws \Exception Throws an exception if the document cannot be signed.
	 */
	public function sign_document( DOMDocument $document ): DOMDocument {
		if ( null === $document->documentElement ) {
			throw new \Exception( 'Not possible to sign document without first document element.' );
		}

		$document_signature = new DOMDocument( '1.0', 'UTF-8' );

		$element_signature = $document_signature->createElementNS( 'http://www.w3.org/2000/09/xmldsig#', 'Signature' );

		$document_signature->appendChild( $element_signature );

		// Signed info.
		$data = $document->C14N( false, false );

		$digest_value = \base64_encode( \hash( 'sha256', $data, true ) );

		$element_signed_info = $this->get_element_signed_info( $document_signature, $digest_value );

		$element_signature->appendChild( $element_signed_info );

		// Signature value.
		$data = $element_signed_info->C14N( true, false );

		$result = \openssl_sign( $data, $signature, $this->private_key, 'sha256WithRSAEncryption' );

		$signature_value = \base64_encode( $signature );

		$element_signature_value = $document_signature->createElement( 'SignatureValue', $signature_value );

		$element_signature->appendChild( $element_signature_value );

		// Key info.
		$element_key_info = $this->get_element_key_info( $document_signature, $this->key_name );

		$element_signature->appendChild( $element_key_info );

		// Sign.
		$signature_element = $document->importNode( $element_signature, true );

		$document->documentElement->appendChild( $signature_element );

		return $document;
	}
}
