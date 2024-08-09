<?php
/**
 * Error parser.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML;

use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\Error;
use SimpleXMLElement;

/**
 * Title: iDEAL Advanced v3 error parser
 * Description:
 * Copyright: 2005-2024 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
class ErrorParser {
	/**
	 * Parse the specified XML element into an acquirer error response
	 *
	 * @param SimpleXMLElement $xml XML.
	 * @return Error|null
	 */
	public function parse( SimpleXMLElement $xml ) {
		if ( 'Error' !== $xml->getName() ) {
			return null;
		}

		return new Error(
			(string) $xml->errorCode,
			(string) $xml->errorMessage,
			(string) $xml->errorDetail,
			(string) $xml->suggestedAction,
			(string) $xml->consumerMessage
		);
	}
}
