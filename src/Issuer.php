<?php
/**
 * Issuer.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3;

/**
 * Title: Issuer
 * Description:
 * Copyright: 2005-2021 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
class Issuer {
	/**
	 * ID of the issuer
	 *
	 * @var string|null
	 */
	private $id;

	/**
	 * Name of the issuer
	 *
	 * @var string|null
	 */
	private $name;

	/**
	 * Authentication URL
	 *
	 * @var string|null
	 */
	private $authentication_url;

	/**
	 * Constructs and initializes an issuer
	 *
	 * @return void
	 */
	public function __construct() {
	}

	/**
	 * Get the ID of this issuer
	 *
	 * @return string|null
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Set the ID of this issuer
	 *
	 * @param string|null $id Issuer ID.
	 * @return void
	 */
	public function set_id( $id ) {
		$this->id = $id;
	}

	/**
	 * Get the name of this issuer
	 *
	 * @return string|null
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * Set the name of this issuer
	 *
	 * @param string|null $name Issuer name.
	 * @return void
	 */
	public function set_name( $name ) {
		$this->name = $name;
	}

	/**
	 * Get the name of this issuer
	 *
	 * @return string|null
	 */
	public function get_authentication_url() {
		return $this->authentication_url;
	}

	/**
	 * Set the name of this issuer
	 *
	 * @param string|null $authentication_url Authentication URL.
	 * @return void
	 */
	public function set_authentication_url( $authentication_url ) {
		$this->authentication_url = $authentication_url;
	}
}
