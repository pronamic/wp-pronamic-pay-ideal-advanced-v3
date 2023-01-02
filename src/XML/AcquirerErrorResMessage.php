<?php
/**
 * Acquirer error response message.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML;

use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\Error;
use SimpleXMLElement;

/**
 * Title: iDEAL error response XML message
 * Description:
 * Copyright: 2005-2023 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
class AcquirerErrorResMessage extends ResponseMessage {
	/**
	 * The document element name
	 *
	 * @var string
	 */
	const NAME = 'AcquirerErrorRes';

	/**
	 * The error within this response message
	 *
	 * @var Error
	 */
	public $error;

	/**
	 * Constructs and initialize an error response message
	 */
	final public function __construct() {
		parent::__construct( self::NAME );
	}

	/**
	 * Parse the specified XML into an directory response message object
	 *
	 * @param SimpleXMLElement $xml XML.
	 * @return AcquirerErrorResMessage
	 * @throws \Exception Throws exception on failed error parsing.
	 */
	public static function parse( SimpleXMLElement $xml ) {
		$message = self::parse_create_date( $xml, new static() );

		// Parse error.
		$parser = new ErrorParser();

		$error = $parser->parse( $xml->Error );

		if ( null === $error ) {
			throw new \Exception( 'Failed to parse error response.' );
		}

		$message->error = $error;

		return $message;
	}
}
