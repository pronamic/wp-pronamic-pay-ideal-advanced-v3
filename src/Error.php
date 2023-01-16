<?php
/**
 * Error.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3;

/**
 * Title: iDEAL Advanced v3 error
 * Description:
 * Copyright: 2005-2023 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
class Error extends \Exception {
	/**
	 * Error code
	 *
	 * @var string
	 */
	private $error_code;

	/**
	 * Error detail
	 *
	 * @var string
	 */
	private $error_detail;

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
	 * Construct error.
	 * 
	 * @param string $code             Code.
	 * @param string $message          Message.
	 * @param string $detail           Detail.
	 * @param string $suggested_action Suggested action.
	 * @param string $consumer_message Consumer message.
	 */
	public function __construct( $code, $message, $detail, $suggested_action, $consumer_message ) {
		parent::__construct( $message );

		$this->error_code       = $code;
		$this->error_detail     = $detail;
		$this->suggested_action = $suggested_action;
		$this->consumer_message = $consumer_message;
	}

	/**
	 * Get error code.
	 *
	 * @return string
	 */
	public function get_code() {
		return $this->error_code;
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
	 * Get error detail.
	 *
	 * @return string
	 */
	public function get_detail() {
		return $this->error_detail;
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
	 * Get consumer message.
	 *
	 * @return string
	 */
	public function get_consumer_message() {
		return $this->consumer_message;
	}
}
