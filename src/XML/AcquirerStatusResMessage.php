<?php

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML;

use Pronamic_WP_Pay_Gateways_IDealAdvancedV3_Transaction;
use SimpleXMLElement;

/**
 * Title: iDEAL status response XML message
 * Description:
 * Copyright: 2005-2020 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
class AcquirerStatusResMessage extends ResponseMessage {
	/**
	 * The document element name
	 *
	 * @var string
	 */
	const NAME = 'AcquirerStatusRes';

	/**
	 * Transaction
	 *
	 * @var Pronamic_WP_Pay_Gateways_IDealAdvancedV3_Transaction
	 */
	public $transaction;

	/**
	 * Constructs and initialize an status response message
	 */
	public function __construct() {
		parent::__construct( self::NAME );
	}

	/**
	 * Parse the specified XML into an directory response message object
	 *
	 * @param SimpleXMLElement $xml
	 *
	 * @return ResponseMessage
	 */
	public static function parse( SimpleXMLElement $xml ) {
		$message = self::parse_create_date( $xml, new self() );

		$message->transaction = TransactionParser::parse( $xml->Transaction );

		return $message;
	}
}
