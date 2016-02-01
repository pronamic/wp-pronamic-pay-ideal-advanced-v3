<?php

/**
 * Title: iDEAL error response XML message
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 */
class Pronamic_WP_Pay_Gateways_IDealAdvancedV3_XML_AcquirerErrorResMessage extends Pronamic_WP_Pay_Gateways_IDealAdvancedV3_XML_ResponseMessage {
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
	 */
	public static function parse( SimpleXMLElement $xml ) {
		$message = self::parse_create_date( $xml, new self() );

		$parser = new Pronamic_WP_Pay_Gateways_IDealAdvancedV3_XML_ErrorParser();
		$message->error = $parser->parse( $xml->Error );

		return $message;
	}
}
