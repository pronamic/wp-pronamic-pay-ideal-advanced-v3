<?php
/**
 * Directory request message.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML;

/**
 * Title: iDEAL directory request XML message
 * Description:
 * Copyright: 2005-2024 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
class DirectoryRequestMessage extends RequestMessage {
	/**
	 * The document element name
	 *
	 * @var string
	 */
	const NAME = 'DirectoryReq';

	/**
	 * Constructs and initialize a directory request message
	 */
	public function __construct() {
		parent::__construct( self::NAME );
	}

	/**
	 * Get document
	 *
	 * @see \Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML\RequestMessage::get_document()
	 */
	public function get_document() {
		$document = parent::get_document();

		// Merchant.
		$merchant = $this->get_merchant();

		$document_element = $document->documentElement;

		if ( null !== $document_element ) {
			$element = self::add_element( $document, $document_element, 'Merchant' );

			self::add_elements(
				$document,
				$element,
				[
					'merchantID' => $merchant->get_id(),
					'subID'      => $merchant->get_sub_id(),
				]
			);
		}

		// Return.
		return $document;
	}
}
