<?php
/**
 * Country parser.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML;

use Pronamic\WordPress\Pay\Core\XML\Security;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\Country;
use SimpleXMLElement;

/**
 * Title: Issuer XML parser
 * Description:
 * Copyright: 2005-2020 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
class CountryParser implements Parser {
	/**
	 * Parse
	 *
	 * @param SimpleXMLElement $xml XML.
	 * @return Country
	 */
	public static function parse( SimpleXMLElement $xml ) {
		$country = new Country();

		// Name.
		$name = Security::filter( $xml->countryNames );

		if ( null !== $name ) {
			$country->set_name( $name );
		}

		// Issuers.
		foreach ( $xml->Issuer as $element ) {
			$issuer = IssuerParser::parse( $element );

			$country->add_issuer( $issuer );
		}

		return $country;
	}
}
