<?php

/**
 * Title: Transaction XML parser
 * Description:
 * Copyright: Copyright (c) 2005 - 2015
 * Company: Pronamic
 * @author Remco Tolsma
 * @version 1.0.0
 */
class Pronamic_WP_Pay_Gateways_IDealAdvancedV3_XML_TransactionParser implements Pronamic_WP_Pay_Gateways_IDealAdvancedV3_XML_Parser {
	/**
	 * Parse the specified XML element into an iDEAL transaction object
	 *
	 * @param SimpleXMLElement $xml
	 * @param Pronamic_Gateways_IDealAdvanced_Transaction $transaction
	 */
	public static function parse( SimpleXMLElement $xml, $transaction = null ) {
		if ( ! $transaction instanceof Pronamic_WP_Pay_Gateways_IDealAdvancedV3_Transaction ) {
			$transaction = new Pronamic_WP_Pay_Gateways_IDealAdvancedV3_Transaction();
		}

		if ( $xml->transactionID ) {
			$transaction->set_id( Pronamic_WP_Pay_XML_Security::filter( $xml->transactionID ) );
		}

		if ( $xml->purchaseID ) {
			$transaction->set_purchase_id( Pronamic_WP_Pay_XML_Security::filter( $xml->purchaseID ) );
		}

		if ( $xml->status ) {
			$transaction->set_status( Pronamic_WP_Pay_XML_Security::filter( $xml->status ) );
		}

		if ( $xml->consumerName ) {
			$transaction->set_consumer_name( Pronamic_WP_Pay_XML_Security::filter( $xml->consumerName ) );
		}

		if ( $xml->consumerIBAN ) {
			$transaction->set_consumer_iban( Pronamic_WP_Pay_XML_Security::filter( $xml->consumerIBAN ) );
		}

		if ( $xml->consumerBIC ) {
			$transaction->set_consumer_bic( Pronamic_WP_Pay_XML_Security::filter( $xml->consumerBIC ) );
		}

		return $transaction;
	}
}
