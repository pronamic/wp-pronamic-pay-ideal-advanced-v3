<?php

/**
 * Title: iDEAL status response XML message
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 */
class Pronamic_WP_Pay_Gateways_IDealAdvancedV3_XML_AcquirerStatusResMessage extends Pronamic_WP_Pay_Gateways_IDealAdvancedV3_XML_ResponseMessage {
	/**
	 * The document element name
	 *
	 * @var string
	 */
	const NAME = 'AcquirerStatusRes';

	//////////////////////////////////////////////////

	/**
	 * Transaction
	 *
	 * @var Pronamic_WP_Pay_Gateways_IDealAdvancedV3_Transaction
	 */
	public $transaction;

	//////////////////////////////////////////////////

	/**
	 * Constructs and initialize an status response message
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

		$message->transaction = Pronamic_WP_Pay_Gateways_IDealAdvancedV3_XML_TransactionParser::parse( $xml->Transaction );

		return $message;
	}
}
