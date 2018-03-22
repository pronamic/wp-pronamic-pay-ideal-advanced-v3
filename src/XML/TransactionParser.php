<?php

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML;

use Pronamic\WordPress\Pay\Core\XML\Security;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\Transaction;
use SimpleXMLElement;

/**
 * Title: Transaction XML parser
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 */
class TransactionParser implements Parser {
	/**
	 * Parse the specified XML element into an iDEAL transaction object
	 *
	 * @param SimpleXMLElement $xml
	 * @param Transaction      $transaction
	 *
	 * @return Transaction
	 */
	public static function parse( SimpleXMLElement $xml, Transaction $transaction = null ) {
		if ( ! $transaction instanceof Transaction ) {
			$transaction = new Transaction();
		}

		if ( $xml->transactionID ) {
			$transaction->set_id( Security::filter( $xml->transactionID ) );
		}

		if ( $xml->purchaseID ) {
			$transaction->set_purchase_id( Security::filter( $xml->purchaseID ) );
		}

		if ( $xml->status ) {
			$transaction->set_status( Security::filter( $xml->status ) );
		}

		if ( $xml->consumerName ) {
			$transaction->set_consumer_name( Security::filter( $xml->consumerName ) );
		}

		if ( $xml->consumerIBAN ) {
			$transaction->set_consumer_iban( Security::filter( $xml->consumerIBAN ) );
		}

		if ( $xml->consumerBIC ) {
			$transaction->set_consumer_bic( Security::filter( $xml->consumerBIC ) );
		}

		return $transaction;
	}
}
