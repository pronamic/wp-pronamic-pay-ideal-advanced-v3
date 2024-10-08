<?php
/**
 * Acquirer status request message.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML;

use DOMDocument;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\Transaction;

/**
 * Title: iDEAL status request XML message
 * Description:
 * Copyright: 2005-2024 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
class AcquirerStatusReqMessage extends RequestMessage {
	/**
	 * The document element name
	 *
	 * @var string
	 */
	const NAME = 'AcquirerStatusReq';

	/**
	 * Transaction
	 *
	 * @var Transaction
	 */
	public $transaction;

	/**
	 * Constructs and initialize an status request message
	 */
	public function __construct() {
		parent::__construct( self::NAME );
	}

	/**
	 * Get document
	 *
	 * @return DOMDocument
	 */
	public function get_document() {
		$document = parent::get_document();

		$document_element = $document->documentElement;

		if ( null !== $document_element ) {
			// Merchant.
			$merchant = $this->get_merchant();

			$element = self::add_element( $document, $document_element, 'Merchant' );

			self::add_elements(
				$document,
				$element,
				[
					'merchantID' => $merchant->get_id(),
					'subID'      => $merchant->get_sub_id(),
				]
			);

			// Transaction.
			$transaction = $this->transaction;

			$element = self::add_element( $document, $document_element, 'Transaction' );

			self::add_element( $document, $element, 'transactionID', $transaction->get_id() );
		}

		return $document;
	}
}
