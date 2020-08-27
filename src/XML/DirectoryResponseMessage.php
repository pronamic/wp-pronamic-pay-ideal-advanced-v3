<?php
/**
 * Directory response message.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML;

use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\Directory;
use SimpleXMLElement;

/**
 * Title: iDEAL directory response XML message
 * Description:
 * Copyright: 2005-2020 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
class DirectoryResponseMessage extends ResponseMessage {
	/**
	 * The document element name
	 *
	 * @var string
	 */
	const NAME = 'DirectoryRes';

	/**
	 * The directory
	 *
	 * @var Directory
	 */
	public $directory;

	/**
	 * Constructs and initialize an directory response message
	 */
	final public function __construct() {
		parent::__construct( self::NAME );
	}

	/**
	 * Get the directory
	 *
	 * @return Directory
	 */
	public function get_directory() {
		return $this->directory;
	}

	/**
	 * Parse the specified XML into an directory response message object
	 *
	 * @param SimpleXMLElement $xml XML.
	 * @return DirectoryResponseMessage
	 */
	public static function parse( SimpleXMLElement $xml ) {
		$message = self::parse_create_date( $xml, new static() );

		$message->directory = DirectoryParser::parse( $xml->Directory );

		return $message;
	}
}
