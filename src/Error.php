<?php
/**
 * Error.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3;

/**
 * Title: iDEAL Advanced v3 error
 * Description:
 * Copyright: 2005-2022 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
class Error {
	/**
	 * Code
	 *
	 * @var string
	 */
	private $code;

	/**
	 * Message
	 *
	 * @var string
	 */
	private $message;

	/**
	 * Detail
	 *
	 * @var string
	 */
	private $detail;

	/**
	 * Suggested action
	 *
	 * @var string
	 */
	private $suggested_action;

	/**
	 * Consumer message
	 *
	 * @var string
	 */
	private $consumer_message;

	/**
	 * Construct and initialize an error.
	 */
	public function __construct() {
	}

	/**
	 * Get error code.
	 *
	 * @return string
	 */
	public function get_code() {
		return $this->code;
	}

	/**
	 * Set error code.
	 *
	 * @param string $code Error code.
	 * @return void
	 */
	public function set_code( $code ) {
		$this->code = $code;
	}

	/**
	 * Get error message.
	 *
	 * @return string
	 */
	public function get_message() {
		return $this->message;
	}

	/**
	 * Set error message.
	 *
	 * @param string $message Error message.
	 * @return void
	 */
	public function set_message( $message ) {
		$this->message = $message;
	}

	/**
	 * Get error detail.
	 *
	 * @return string
	 */
	public function get_detail() {
		return $this->detail;
	}

	/**
	 * Set error detail.
	 *
	 * @param string $detail Detail.
	 * @return void
	 */
	public function set_detail( $detail ) {
		$this->detail = $detail;
	}

	/**
	 * Get suggested action.
	 *
	 * @return string
	 */
	public function get_suggested_action() {
		return $this->suggested_action;
	}

	/**
	 * Set suggested action.
	 *
	 * @param string $suggested_action Suggested action.
	 * @return void
	 */
	public function set_suggested_action( $suggested_action ) {
		$this->suggested_action = $suggested_action;
	}

	/**
	 * Get consumer message.
	 *
	 * @return string
	 */
	public function get_consumer_message() {
		return $this->consumer_message;
	}

	/**
	 * Set consumer message.
	 *
	 * @param string $consumer_message Consumer message.
	 * @return void
	 */
	public function set_consumer_message( $consumer_message ) {
		$this->consumer_message = $consumer_message;
	}

	/**
	 * Create a string representation of this object.
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->code . ' ' . $this->message;
	}
}
