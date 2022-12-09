<?php
/**
 * Error parser.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML;

use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\Error;
use Pronamic\WordPress\Pay\Core\XML\Security;
use SimpleXMLElement;

/**
 * Title: iDEAL Advanced v3 error parser
 * Description:
 * Copyright: 2005-2022 Pronamic
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

		$error = new Error();

		$error->set_code( (string) $xml->errorCode );
		$error->set_message( (string) $xml->errorMessage );
		$error->set_detail( (string) $xml->errorDetail );
		$error->set_suggested_action( (string) $xml->suggestedAction );
		$error->set_consumer_message( (string) $xml->consumerMessage );

		return $error;
	}
}
