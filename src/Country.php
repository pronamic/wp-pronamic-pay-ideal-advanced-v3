<?php

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3;

/**
 * Title: Country
 * Description:
 * Copyright: 2005-2020 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
class Country {
	/**
	 * The date the issuer list was modified
	 *
	 * @var string
	 */
	private $name;

	/**
	 * The countries in this directory
	 *
	 * @var array
	 */
	private $issuers;

	/**
	 * Constructs and initializes an country
	 */
	public function __construct() {
		$this->issuers = array();
	}

	/**
	 * Get the name
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * Set the name
	 *
	 * @param string $name
	 */
	public function set_name( $name ) {
		$this->name = $name;
	}

	/**
	 * Add the specified issuer to this country
	 *
	 * @param Issuer $issuer
	 */
	public function add_issuer( Issuer $issuer ) {
		$this->issuers[] = $issuer;
	}

	/**
	 * Get the issuers within this directory
	 *
	 * @return array
	 */
	public function get_issuers() {
		return $this->issuers;
	}
}
