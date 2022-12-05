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

/**
 * XML Signer class
 */
class XmlSigner {
	private $certificate;

	private $private_key;

	private $private_key_password;

	public function __construct( $certificate, $private_key, $private_key_password ) {
		$this->certificate = $certificate;
		$this->private_key = $private_key;
		$this->private_key_password = $private_key_password;
	}

	/**
	 * PEM to DER.
	 * 
	 * @link https://knowledge.digicert.com/solution/SO26449.html
	 * @link https://www.openssl.org/docs/man1.0.2/man1/x509.html
	 * @link https://stackoverflow.com/questions/36503814/why-are-pem2der-and-der2pem-not-inverses
	 */
	private function pem_to_der( $certificate ) {
		$value = $certificate;

		$value = \str_replace( '-----BEGIN CERTIFICATE-----', '', $value );
		$value = \str_replace( '-----END CERTIFICATE-----', '', $value );
		$value = \trim( $value );

		$value = \base64_decode( $value );

		return $value;
	}

	public function sign_document( DOMDocument $document ) {
		$document_signature = new DOMDocument( '1.0', 'UTF-8' );

		$element_signature = $document_signature->createElementNS( 'http://www.w3.org/2000/09/xmldsig#', 'Signature' );

		$document_signature->appendChild( $element_signature );

		$element_signed_info = $document_signature->createElement( 'SignedInfo' );

		$element_signature->appendChild( $element_signed_info );

		$element_canonicalization_method = $document_signature->createElement( 'CanonicalizationMethod' );
		$element_canonicalization_method->setAttribute( 'Algorithm', 'http://www.w3.org/2001/10/xml-exc-c14n#' );

		$element_signed_info->appendChild( $element_canonicalization_method );

		$element_signature_method = $document_signature->createElement( 'SignatureMethod' );
		$element_signature_method->setAttribute( 'Algorithm', 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256' );

		$element_signed_info->appendChild( $element_signature_method );

		$element_reference = $document_signature->createElement( 'Reference' );
		$element_reference->setAttribute( 'URI', '' );

		$element_signed_info->appendChild( $element_reference );

		$element_transforms = $document_signature->createElement( 'Transforms' );

		$element_reference->appendChild( $element_transforms );

		$element_transform = $document_signature->createElement( 'Transform' );
		$element_transform->setAttribute( 'Algorithm', 'http://www.w3.org/2000/09/xmldsig#enveloped-signature' );

		$element_transforms->appendChild( $element_transform );

		$element_digest_method = $document_signature->createElement( 'DigestMethod' );
		$element_digest_method->setAttribute( 'Algorithm', 'http://www.w3.org/2001/04/xmlenc#sha256' );

		$element_reference->appendChild( $element_digest_method );

		$data = $document->C14N( false, false );

		$digest_value = base64_encode( hash( 'sha256', $data, true ) );

		$element_digest_value = $document_signature->createElement( 'DigestValue', $digest_value );

		$element_reference->appendChild( $element_digest_value );

		$data = $element_signed_info->C14N( true, false );

		$private_key = openssl_get_privatekey( $this->private_key, $this->private_key_password );

		$result = openssl_sign( $data, $signature, $private_key, 'sha256WithRSAEncryption' );

		$signature_value = base64_encode( $signature );

		$element_signature_value = $document_signature->createElement( 'SignatureValue', $signature_value );

		$element_signature->appendChild( $element_signature_value );

		$element_key_info = $document_signature->createElement( 'KeyInfo' );

		$element_signature->appendChild( $element_key_info );

		$fingerprint = strtoupper( hash( 'sha1', $this->pem_to_der( $this->certificate ) ) );

		$element_key_name = $document_signature->createElement( 'KeyName', $fingerprint );

		$element_key_info->appendChild( $element_key_name );

		$signature_element = $document->importNode( $element_signature, true );

		$document->documentElement->appendChild( $signature_element );

		return $document;
	}
}
