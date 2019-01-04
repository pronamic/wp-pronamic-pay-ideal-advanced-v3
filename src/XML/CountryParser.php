<?php

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML;

use Pronamic\WordPress\Pay\Core\XML\Security;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\Country;
use SimpleXMLElement;

/**
 * Title: Issuer XML parser
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
class CountryParser implements Parser {
	/**
	 * Parse
	 *
	 * @param SimpleXMLElement $xml
	 *
	 * @return Country
	 */
	public static function parse( SimpleXMLElement $xml ) {
		$country = new Country();

		$country->set_name( Security::filter( $xml->countryNames ) );

		foreach ( $xml->Issuer as $element ) {
			$issuer = IssuerParser::parse( $element );

			$country->add_issuer( $issuer );
		}

		return $country;
	}
}
