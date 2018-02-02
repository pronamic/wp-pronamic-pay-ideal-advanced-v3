<?php

namespace Pronamic\WordPress\Pay\Gateways\IDeal_Advanced_V3\XML;

use Pronamic_WP_Pay_Gateways_IDealAdvancedV3_Error;
use SimpleXMLElement;

/**
 * Title: iDEAL error response XML message
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 */
class AcquirerErrorResMessage extends ResponseMessage {
	/**
	 * The document element name
	 *
	 * @var string
	 */
	const NAME = 'AcquirerErrorRes';

	//////////////////////////////////////////////////

	/**
	 * The error within this response message
	 *
	 * @var Pronamic_WP_Pay_Gateways_IDealAdvancedV3_Error
	 */
	public $error;

	//////////////////////////////////////////////////

	/**
	 * Constructs and initialize an error response message
	 */
	public function __construct() {
		parent::__construct( self::NAME );
	}

	//////////////////////////////////////////////////

	/**
	 * Parse the specified XML into an directory response message object
	 *
	 * @param SimpleXMLElement $xml
	 *
	 * @return ResponseMessage
	 */
	public static function parse( SimpleXMLElement $xml ) {
		$message = self::parse_create_date( $xml, new self() );

		$parser = new ErrorParser();

		$message->error = $parser->parse( $xml->Error );

		return $message;
	}
}
