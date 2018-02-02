<?php

namespace Pronamic\WordPress\Pay\Gateways\IDeal_Advanced_V3\XML;

use Pronamic\WordPress\Pay\Gateways\IDeal_Advanced_V3\IDeal;
use Pronamic\WordPress\Pay\Gateways\IDeal_Advanced_V3\Issuer;
use Pronamic\WordPress\Pay\Gateways\IDeal_Advanced_V3\Transaction;

/**
 * Title: iDEAL transaction request XML message
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 */
class TransactionRequestMessage extends RequestMessage {
	/**
	 * The document element name
	 *
	 * @var string
	 */
	const NAME = 'AcquirerTrxReq';

	//////////////////////////////////////////////////

	/**
	 * Issuer
	 *
	 * @var Issuer
	 */
	public $issuer;

	/**
	 * Transaction
	 *
	 * @var Transaction
	 */
	public $transaction;

	//////////////////////////////////////////////////

	/**
	 * Constructs and initializes an transaction request message
	 */
	public function __construct() {
		parent::__construct( self::NAME );
	}

	//////////////////////////////////////////////////

	/**
	 * Get document
	 *
	 * @see RequestMessage::get_document()
	 */
	public function get_document() {
		$document = parent::get_document();

		// Issuer
		$issuer = $this->issuer;

		$element = self::add_element( $document, $document->documentElement, 'Issuer' );
		self::add_element( $document, $element, 'issuerID', $issuer->get_id() );

		// Merchant
		$merchant = $this->get_merchant();

		$element = self::add_element( $document, $document->documentElement, 'Merchant' );
		self::add_elements( $document, $element, array(
			'merchantID'        => $merchant->get_id(),
			'subID'             => $merchant->get_sub_id(),
			'merchantReturnURL' => $merchant->get_return_url(),
		) );

		// Transaction
		$transaction = $this->transaction;

		$element = self::add_element( $document, $document->documentElement, 'Transaction' );
		self::add_elements( $document, $element, array(
			'purchaseID'       => $transaction->get_purchase_id(),
			'amount'           => IDeal::format_amount( $transaction->get_amount() ),
			'currency'         => $transaction->get_currency(),
			'expirationPeriod' => $transaction->get_expiration_period(),
			'language'         => $transaction->get_language(),
			'description'      => $transaction->get_description(),
			'entranceCode'     => $transaction->get_entrance_code(),
		) );

		// Return
		return $document;
	}
}
