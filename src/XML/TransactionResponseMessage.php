<?php
/**
 * Transaction response message.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML;

use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\Issuer;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\Transaction;
use SimpleXMLElement;

/**
 * Title: iDEAL transaction response XML message
 * Description:
 * Copyright: 2005-2023 Pronamic
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
	 * Issuer.
	 *
	 * @var Issuer|null
	 */
	public $issuer;

	/**
	 * Transaction.
	 *
	 * @var Transaction|null
	 */
	public $transaction;

	/**
	 * Constructs and initialize an directory response message
	 */
	final public function __construct() {
		parent::__construct( self::NAME );
	}

	/**
	 * Parse the specified XML into an directory response message object
	 *
	 * @param SimpleXMLElement $xml XML.
	 * @return TransactionResponseMessage
	 */
	public static function parse( SimpleXMLElement $xml ) {
		$message = self::parse_create_date( $xml, new static() );

		$message->issuer      = IssuerParser::parse( $xml->Issuer );
		$message->transaction = TransactionParser::parse( $xml->Transaction );

		return $message;
	}
}
