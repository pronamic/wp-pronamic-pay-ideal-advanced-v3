<?php

/**
 * Title: Issuer XML parser
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 */
class Pronamic_WP_Pay_Gateways_IDealAdvancedV3_XML_CountryParser implements Pronamic_WP_Pay_Gateways_IDealAdvancedV3_XML_Parser {
	/**
	 * Parse
	 *
	 * @param SimpleXMLElement $xml
	 * @return Pronamic_Gateways_IDealAdvanced_Directory
	 */
	public static function parse( SimpleXMLElement $xml ) {
		$country = new Pronamic_WP_Pay_Gateways_IDealAdvancedV3_Country();

		$country->set_name( Pronamic_WP_Pay_XML_Security::filter( $xml->countryNames ) );

		foreach ( $xml->Issuer as $element ) {
			$issuer = Pronamic_WP_Pay_Gateways_IDealAdvancedV3_XML_IssuerParser::parse( $element );

			$country->add_issuer( $issuer );
		}

		return $country;
	}
}
