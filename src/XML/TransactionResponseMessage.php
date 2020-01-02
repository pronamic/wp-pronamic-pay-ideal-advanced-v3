<?php

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML;

use SimpleXMLElement;

/**
 * Title: iDEAL transaction response XML message
 * Description:
 * Copyright: 2005-2020 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
class TransactionResponseMessage extends ResponseMessage {
	/**
	 * The document element name
	 *
	 * @var string
	 */
	const NAME = 'AcquirerTrxRes';

	/**
	 * Constructs and initialize an directory response message
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

		$message->issuer      = IssuerParser::parse( $xml->Issuer );
		$message->transaction = TransactionParser::parse( $xml->Transaction );

		return $message;
	}
}
