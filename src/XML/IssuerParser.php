<?php
use Pronamic\WordPress\Pay\Core\XML\Security;

/**
 * Title: Issuer XML parser
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 */
class Pronamic_WP_Pay_Gateways_IDealAdvancedV3_XML_IssuerParser implements Pronamic_WP_Pay_Gateways_IDealAdvancedV3_XML_Parser {
	/**
	 * Parse
	 *
	 * @param SimpleXMLElement $xml
	 * @param Pronamic_Gateways_IDealAdvanced_Issuer $issuer
	 */
	public static function parse( SimpleXMLElement $xml, $issuer = null ) {
		if ( ! $issuer instanceof Pronamic_WP_Pay_Gateways_IDealAdvancedV3_Issuer ) {
			$issuer = new Pronamic_WP_Pay_Gateways_IDealAdvancedV3_Issuer();
		}

		if ( $xml->issuerID ) {
			$issuer->set_id( Security::filter( $xml->issuerID ) );
		}

		if ( $xml->issuerName ) {
			$issuer->set_name( Security::filter( $xml->issuerName ) );
		}

		if ( $xml->issuerAuthenticationURL ) {
			$issuer->set_authentication_url( Security::filter( $xml->issuerAuthenticationURL ) );
		}

		return $issuer;
	}
}
