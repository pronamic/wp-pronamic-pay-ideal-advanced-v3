<?php
/**
 * Transaction request message.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML;

use DOMDocument;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\IDeal;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\Issuer;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\Transaction;

/**
 * Title: iDEAL transaction request XML message
 * Description:
 * Copyright: 2005-2022 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.1
 */
class TransactionRequestMessage extends RequestMessage {
	/**
	 * The document element name
	 *
	 * @var string
	 */
	const NAME = 'AcquirerTrxReq';

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

	/**
	 * Constructs and initializes an transaction request message
	 */
	public function __construct() {
		parent::__construct( self::NAME );
	}

	/**
	 * Get document
	 *
	 * @see RequestMessage::get_document()
	 * @return DOMDocument
	 * @throws \Exception Throws exception if no transaction amount has been set.
	 */
	public function get_document() {
		$document = parent::get_document();

		$document_element = $document->documentElement;

		if ( null !== $document_element ) {
			// Issuer.
			$issuer = $this->issuer;

			$element = self::add_element( $document, $document_element, 'Issuer' );

			self::add_elements(
				$document,
				$element,
				[
					'issuerID' => $issuer->get_id(),
				]
			);

			// Merchant.
			$merchant = $this->get_merchant();

			$element = self::add_element( $document, $document_element, 'Merchant' );

			self::add_elements(
				$document,
				$element,
				[
					'merchantID'        => $merchant->get_id(),
					'subID'             => $merchant->get_sub_id(),
					'merchantReturnURL' => $merchant->get_return_url(),
				]
			);

			// Transaction.
			$transaction = $this->transaction;

			$element = self::add_element( $document, $document_element, 'Transaction' );

			$amount = $transaction->get_amount();

			if ( null === $amount ) {
				throw new \Exception( 'Required iDEAL transaction amount has not been set.' );
			}

			self::add_elements(
				$document,
				$element,
				[
					'purchaseID'       => $transaction->get_purchase_id(),
					'amount'           => $amount,
					'currency'         => $transaction->get_currency(),
					'expirationPeriod' => $transaction->get_expiration_period(),
					'language'         => $transaction->get_language(),
					'description'      => $transaction->get_description(),
					'entranceCode'     => $transaction->get_entrance_code(),
				]
			);
		}

		// Return.
		return $document;
	}
}
