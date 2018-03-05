<?php

namespace Pronamic\WordPress\Pay\Gateways\IDeal_Advanced_V3\XML;

use DOMDocument;
use Pronamic\WordPress\Pay\Gateways\IDeal_Advanced_V3\Merchant;

/**
 * Title: iDEAL request XML message
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 */
abstract class RequestMessage extends Message {
	/**
	 * Merchant
	 *
	 * @var Merchant
	 */
	private $merchant;

	/**
	 * Constructs and initialize an request message
	 *
	 * @param string $name
	 */
	public function __construct( $name ) {
		parent::__construct( $name );

		$this->merchant = new Merchant();
	}

	/**
	 * Get the merchant
	 *
	 * @return string
	 */
	public function get_merchant() {
		return $this->merchant;
	}

	/**
	 * Get the DOM document
	 *
	 * @return DOMDocument
	 */
	public function get_document() {
		$document = new DOMDocument( parent::XML_VERSION, parent::XML_ENCODING );
		// We can't disable preservere white space and format the output
		// this is causing 'Invalid electronic signature' errors
		// $document->preserveWhiteSpace = true;
		// $document->formatOutput = true;

		// Root
		$root = $document->createElementNS( parent::XML_NAMESPACE, $this->get_name() );
		$root->setAttribute( 'version', parent::VERSION );

		$document->appendChild( $root );

		// Create date timestamp
		// Using DateTime::ISO8601 won't work, this is giving an error
		$timestamp = $this->get_create_date()->format( 'Y-m-d\TH:i:s.000\Z' );

		$element = $document->createElement( 'createDateTimestamp', $timestamp );

		$root->appendChild( $element );

		return $document;
	}

	/**
	 * Create a string representation
	 *
	 * @return string
	 */
	public function __toString() {
		$document = $this->get_document();

		return $document->saveXML();
	}
}
