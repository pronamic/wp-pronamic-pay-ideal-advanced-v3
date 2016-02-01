<?php

/**
 * Title: iDEAL XML message
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 */
class Pronamic_WP_Pay_Gateways_IDealAdvancedV3_XML_Message {
	/**
	 * The XML version of the iDEAL messages
	 *
	 * @var string
	 */
	const XML_VERSION = '1.0';

	/**
	 * The XML encoding of the iDEAL messages
	 *
	 * @var string
	 */
	const XML_ENCODING = 'UTF-8';

	/**
	 * The XML namespace of the iDEAL messages
	 *
	 * @var string
	 */
	const XML_NAMESPACE = 'http://www.idealdesk.com/ideal/messages/mer-acq/3.3.1';

	//////////////////////////////////////////////////

	/**
	 * The version of the iDEAL messages
	 *
	 * @var string
	 */
	const VERSION = '3.3.1';

	//////////////////////////////////////////////////

	/**
	 * The name of this message
	 *
	 * @var string
	 */
	private $name;

	//////////////////////////////////////////////////

	/**
	 * The create date of this message
	 *
	 * @var DateTime
	 */
	private $create_date;

	//////////////////////////////////////////////////

	/**
	 * Constructs and initialize an message
	 */
	public function __construct( $name ) {
		$this->name = $name;
		$this->create_date = new DateTime( null, new DateTimeZone( Pronamic_IDeal_IDeal::TIMEZONE ) );
	}

	//////////////////////////////////////////////////

	/**
	 * Get the name of this message
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->name;
	}

	//////////////////////////////////////////////////

	/**
	 * Get the create date
	 *
	 * @return DateTime
	 */
	public function get_create_date() {
		return $this->create_date;
	}

	/**
	 * Set the create date
	 *
	 * @return DateTime
	 */
	public function set_create_date( DateTime $create_date ) {
		$this->create_date = $create_date;
	}

	//////////////////////////////////////////////////

	/**
	 * Create and add an element with the specified name and value to the specified parent
	 *
	 * @param DOMDocument $document
	 * @param DOMNode $parent
	 * @param string $name
	 * @param string $value
	 */
	public static function add_element( DOMDocument $document, DOMNode $parent, $name, $value = null ) {
		$element = $document->createElement( $name );

		if ( null !== $value ) {
			$element->appendChild( new DOMText( $value ) );
		}

		$parent->appendChild( $element );

		return $element;
	}

	/**
	 * Add the specified elements to the parent node
	 *
	 * @param DOMDocument $document
	 * @param DOMNode $parent
	 * @param array $elements
	 */
	public static function add_elements( DOMDocument $document, DOMNode $parent, array $elements = array() ) {
		foreach ( $elements as $name => $value ) {
			$element = $document->createElement( $name );

			if ( null !== $value ) {
				$element->appendChild( new DOMText( $value ) );
			}

			$parent->appendChild( $element );
		}
	}
}
