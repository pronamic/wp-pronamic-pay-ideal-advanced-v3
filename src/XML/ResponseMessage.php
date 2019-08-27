<?php

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML;

use Pronamic\WordPress\DateTime\DateTime;
use SimpleXMLElement;

/**
 * Title: iDEAL response XML message
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
abstract class ResponseMessage extends Message {
	/**
	 * Parse the specified XML into an directory response message object
	 *
	 * @param SimpleXMLElement $xml
	 * @param ResponseMessage  $message
	 *
	 * @return ResponseMessage
	 */
	public static function parse_create_date( SimpleXMLElement $xml, self $message ) {
		if ( $xml->createDateTimestamp ) {
			$date = new DateTime( (string) $xml->createDateTimestamp );

			$message->set_create_date( $date );
		}

		return $message;
	}
}
