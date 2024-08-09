<?php
/**
 * Response message.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML;

use DateTimeImmutable;
use SimpleXMLElement;

/**
 * Title: iDEAL response XML message
 * Description:
 * Copyright: 2005-2024 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
abstract class ResponseMessage extends Message {
	/**
	 * Parse the specified XML into a response message object
	 *
	 * @param SimpleXMLElement $xml     XML.
	 * @param static           $message Message.
	 * @return static
	 * @throws \Exception Throws exception on date error.
	 */
	public static function parse_create_date( SimpleXMLElement $xml, $message ) {
		if ( ! empty( $xml->createDateTimestamp ) ) {
			$date = new DateTimeImmutable( (string) $xml->createDateTimestamp );

			$message->set_create_date( $date );
		}

		return $message;
	}
}
