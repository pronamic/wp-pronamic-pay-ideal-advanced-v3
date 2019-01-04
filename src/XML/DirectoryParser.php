<?php

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML;

use Pronamic\WordPress\DateTime\DateTime;
use Pronamic\WordPress\Pay\Core\XML\Security;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\Directory;
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
class DirectoryParser implements Parser {
	/**
	 * Parse
	 *
	 * @param SimpleXMLElement $xml
	 *
	 * @return Directory
	 */
	public static function parse( SimpleXMLElement $xml ) {
		$directory = new Directory();

		$timestamp = Security::filter( $xml->directoryDateTimestamp );
		$directory->set_date( new DateTime( $timestamp ) );

		foreach ( $xml->Country as $element ) {
			$country = CountryParser::parse( $element );

			$directory->add_country( $country );
		}

		return $directory;
	}
}
