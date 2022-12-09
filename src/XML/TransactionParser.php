<?php
/**
 * Transaction parser.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML;

use Pronamic\WordPress\Pay\Core\XML\Security;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\Transaction;
use SimpleXMLElement;

/**
 * Title: Transaction XML parser
 * Description:
 * Copyright: 2005-2022 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
class TransactionParser implements Parser {
	/**
	 * Parse the specified XML element into an iDEAL transaction object
	 *
	 * @param SimpleXMLElement $xml         XML.
	 * @param Transaction      $transaction Transaction.
	 *
	 * @return Transaction
	 */
	public static function parse( SimpleXMLElement $xml, Transaction $transaction = null ) {
		if ( ! $transaction instanceof Transaction ) {
			$transaction = new Transaction();
		}

		$transaction->set_id( (string) $xml->transactionID );
		$transaction->set_purchase_id( (string) $xml->purchaseID );
		$transaction->set_status( (string) $xml->status );
		$transaction->set_consumer_name( (string) $xml->consumerName );
		$transaction->set_consumer_iban( (string) $xml->consumerIBAN );
		$transaction->set_consumer_bic( (string) $xml->consumerBIC );

		return $transaction;
	}
}
