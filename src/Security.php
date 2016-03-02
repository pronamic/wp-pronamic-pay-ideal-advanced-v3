<?php

/**
 * Title: Security
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 */
class Pronamic_WP_Pay_Gateways_IDealAdvancedV3_Security {
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

	//////////////////////////////////////////////////

	/**
	 * Get the sha1 fingerprint from the specified certificate
	 *
	 * @param string $certificate
	 * @return fingerprint or null on failure
	 */
	public static function get_sha_fingerprint( $certificate ) {
		return self::get_fingerprint( $certificate, 'sha1' );
	}

	/**
	 * Get the md5 fingerprint from the specified certificate
	 *
	 * @param string $certificate
	 * @return fingerprint or null on failure
	 */
	public static function get_md5_fingerprint( $certificate ) {
		return self::get_fingerprint( $certificate, 'md5' );
	}

	/**
	 * Get the fingerprint from the specified certificate
	 *
	 * @param string $certificate
	 * @return fingerprint or null on failure
	 */
	public static function get_fingerprint( $certificate, $hash = null ) {
		$fingerprint = null;

		// The openssl_x509_read() function will throw an warning if the supplied
		// parameter cannot be coerced into an X509 certificate
		// @codingStandardsIgnoreStart
		$resource = @openssl_x509_read( $certificate );
		// @codingStandardsIgnoreEnd

		if ( false !== $resource ) {
			$output = null;

			$result = openssl_x509_export( $resource, $output );
			if ( false !== $result ) {
				$output = str_replace( self::CERTIFICATE_BEGIN, '', $output );
				$output = str_replace( self::CERTIFICATE_END, '', $output );

				// Base64 decode
				$fingerprint = base64_decode( $output );

				// Hash
				if ( null !== $hash ) {
					$fingerprint = hash( $hash, $fingerprint );
				}
			} // @todo else what to do?
		} // @todo else what to do?

		return $fingerprint;
	}
}
