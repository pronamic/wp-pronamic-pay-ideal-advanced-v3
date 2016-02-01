<?php

/**
 * Title: iDEAL status request XML message
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 */
class Pronamic_WP_Pay_Gateways_IDealAdvancedV3_XML_AcquirerStatusReqMessage extends Pronamic_WP_Pay_Gateways_IDealAdvancedV3_XML_RequestMessage {
	/**
	 * The document element name
	 *
	 * @var string
	 */
	const NAME = 'AcquirerStatusReq';

	//////////////////////////////////////////////////

	/**
	 * Transaction
	 *
	 * @var Pronamic_WP_Pay_Gateways_IDealAdvancedV3_Transaction
	 */
	public $transaction;

	//////////////////////////////////////////////////

	/**
	 * Constructs and initialize an status request message
	 */
	public function __construct() {
		parent::__construct( self::NAME );
	}

	//////////////////////////////////////////////////

	/**
	 * Get document
	 *
	 * @return DOMDocument
	 */
	public function get_document() {
		$document = parent::get_document();

		// Root
		$root = $document->documentElement;

		// Merchant
		$merchant = $this->get_merchant();

		$element = self::add_element( $document, $document->documentElement, 'Merchant' );
		self::add_elements( $document, $element, array(
			'merchantID' => $merchant->get_id(),
			'subID'      => $merchant->get_sub_id(),
		) );

		// Transaction
		$transaction = $this->transaction;

		$element = self::add_element( $document, $document->documentElement, 'Transaction' );
		self::add_element( $document, $element, 'transactionID', $transaction->get_id() );

		// Return
		return $document;
	}
}
