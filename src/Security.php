<?php

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3;

/**
 * Title: Security
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 * @since   1.0.0
 */
class Security {
	/**
	 * Indicator for the begin of an certificate
	 *
	 * @var string
	 */
	const CERTIFICATE_BEGIN = '-----BEGIN CERTIFICATE-----';

	/**
	 * Indicator for the end of an certificate
	 *
	 * @var string
	 */
	const CERTIFICATE_END = '-----END CERTIFICATE-----';

	/**
	 * Get the sha1 fingerprint from the specified certificate
	 *
	 * @param string $certificate
	 *
	 * @return string Fingerprint or null on failure
	 */
	public static function get_sha_fingerprint( $certificate ) {
		return self::get_fingerprint( $certificate, 'sha1' );
	}

	/**
	 * Get the md5 fingerprint from the specified certificate
	 *
	 * @param string $certificate
	 *
	 * @return string Fingerprint or null on failure
	 */
	public static function get_md5_fingerprint( $certificate ) {
		return self::get_fingerprint( $certificate, 'md5' );
	}

	/**
	 * Get the fingerprint from the specified certificate
	 *
	 * @param string $certificate
	 *
	 * @return string Fingerprint or null on failure
	 */
	public static function get_fingerprint( $certificate, $hash = null ) {
		$fingerprint = null;

		// The openssl_x509_read() function will throw an warning if the supplied
		// parameter cannot be coerced into an X509 certificate
		// @codingStandardsIgnoreStart
		$resource = @openssl_x509_read( $certificate );
		// @codingStandardsIgnoreEnd

		if ( false === $resource ) {
			return false;
		}

		$output = null;

		$result = openssl_x509_export( $resource, $output );

		if ( false === $result ) {
			return false;
		}

		$output = str_replace( self::CERTIFICATE_BEGIN, '', $output );
		$output = str_replace( self::CERTIFICATE_END, '', $output );

		// Base64 decode
		$fingerprint = base64_decode( $output );

		// Hash
		if ( null !== $hash ) {
			$fingerprint = hash( $hash, $fingerprint );
		}

		/*
		 * Uppercase
		 *
		 * Cannot find private certificate file with fingerprint: b4845cb5cbcee3e1e0afef2662552a2365960e72
		 * (Note: Some acquirers only accept fingerprints in uppercase. Make the value of "KeyName" in your XML data uppercase.).
		 * https://www.ideal-checkout.nl/simulator/
		 *
		 * @since 1.1.11
		 */
		$fingerprint = strtoupper( $fingerprint );

		return $fingerprint;
	}
}
