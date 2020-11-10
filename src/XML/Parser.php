<?php
/**
 * Parser.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML;

use SimpleXMLElement;

/**
 * Title: XML parser
 * Description:
 * Copyright: 2005-2020 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
interface Parser {
	/**
	 * Parse the specified XML element
	 *
	 * @param SimpleXMLElement $xml XML.
	 * @return mixed
	 */
	public static function parse( SimpleXMLElement $xml );
}
