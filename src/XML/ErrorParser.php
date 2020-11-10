<?php
/**
 * Error parser.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
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
 * Copyright: 2005-2020 Pronamic
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

		// Error code.
		$code = Security::filter( $xml->errorCode );

		if ( null !== $code ) {
			$error->set_code( $code );
		}

		// Message.
		$message = Security::filter( $xml->errorMessage );

		if ( null !== $message ) {
			$error->set_message( $message );
		}

		// Detail.
		$detail = Security::filter( $xml->errorDetail );

		if ( null !== $detail ) {
			$error->set_detail( $detail );
		}

		// Suggested action.
		$suggested_action = Security::filter( $xml->suggestedAction );

		if ( null !== $suggested_action ) {
			$error->set_suggested_action( $suggested_action );
		}

		// Consumer message.
		$consumer_message = Security::filter( $xml->consumerMessage );

		if ( null !== $consumer_message ) {
			$error->set_consumer_message( $consumer_message );
		}

		return $error;
	}
}
