<?php

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML;

use SimpleXMLElement;

/**
 * Title: XML parser
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
interface Parser {
	/**
	 * Parse the specified XML element
	 *
	 * @param SimpleXMLElement $xml
	 */
	public static function parse( SimpleXMLElement $xml );
}
