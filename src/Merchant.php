<?php
/**
 * Merchant.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3;

/**
 * Title: Merchant
 * Description:
 * Copyright: 2005-2024 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
class Merchant {
	/**
	 * ID of the merchant
	 *
	 * @var string
	 */
	private $id;

	/**
	 * Sub ID
	 *
	 * @var string
	 */
	private $sub_id;

	/**
	 * Return URL
	 *
	 * @var string
	 */
	private $return_url;

	/**
	 * Constructs and initializes an issuer
	 *
	 * @return void
	 */
	public function __construct() {
	}

	/**
	 * Get the ID of this merchant
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Set the ID of this merchant
	 *
	 * @param string $id Merchant ID.
	 * @return void
	 */
	public function set_id( $id ) {
		$this->id = $id;
	}

	/**
	 * Get the ID of this merchant
	 *
	 * @return string
	 */
	public function get_sub_id() {
		return $this->sub_id;
	}

	/**
	 * Set the ID of this merchant
	 *
	 * @param string $sub_id Sub ID.
	 * @return void
	 */
	public function set_sub_id( $sub_id ) {
		$this->sub_id = $sub_id;
	}

	/**
	 * Get the return URL of this merchant
	 *
	 * @return string
	 */
	public function get_return_url() {
		return $this->return_url;
	}

	/**
	 * Set the ID of this merchant
	 *
	 * @param string $return_url Return URL.
	 * @return void
	 */
	public function set_return_url( $return_url ) {
		$this->return_url = $return_url;
	}
}
