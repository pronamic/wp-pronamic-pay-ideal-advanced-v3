<?php
/**
 * Country.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3;

/**
 * Title: Country
 * Description:
 * Copyright: 2005-2024 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
class Country {
	/**
	 * Country name.
	 *
	 * @var string
	 */
	private $name;

	/**
	 * Issuers for this country.
	 *
	 * @var array<int, Issuer>
	 */
	private $issuers;

	/**
	 * Constructs and initializes an country
	 */
	public function __construct() {
		$this->issuers = [];
	}

	/**
	 * Get the country name.
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * Set the country name.
	 *
	 * @param string $name Name.
	 * @return void
	 */
	public function set_name( $name ) {
		$this->name = $name;
	}

	/**
	 * Add issuer to this country.
	 *
	 * @param Issuer $issuer Issuer.
	 * @return void
	 */
	public function add_issuer( Issuer $issuer ) {
		$this->issuers[] = $issuer;
	}

	/**
	 * Get the issuers within this country.
	 *
	 * @return array<int, Issuer>
	 */
	public function get_issuers() {
		return $this->issuers;
	}
}
