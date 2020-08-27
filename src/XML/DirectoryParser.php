<?php
/**
 * Directory parser.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML;

use Pronamic\WordPress\DateTime\DateTime;
use Pronamic\WordPress\Pay\Core\XML\Security;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\Directory;
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
class DirectoryParser implements Parser {
	/**
	 * Parse
	 *
	 * @param SimpleXMLElement $xml XML.
	 * @return Directory
	 * @throws \Exception Throws exception on date error.
	 */
	public static function parse( SimpleXMLElement $xml ) {
		$directory = new Directory();

		// Date.
		$timestamp = Security::filter( $xml->directoryDateTimestamp );

		if ( null !== $timestamp ) {
			$directory->set_date( new DateTime( $timestamp ) );
		}

		// Country.
		foreach ( $xml->Country as $element ) {
			$country = CountryParser::parse( $element );

			$directory->add_country( $country );
		}

		return $directory;
	}
}
