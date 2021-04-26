<?php
/**
 * Directory.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3;

use Pronamic\WordPress\DateTime\DateTime;

/**
 * Title: Directory
 * Description:
 * Copyright: 2005-2021 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
class Directory {
	/**
	 * The date the issuer list was modified
	 *
	 * @var DateTime
	 */
	private $date;

	/**
	 * The countries in this directory
	 *
	 * @var array<int, Country>
	 */
	private $countries;

	/**
	 * Constructs and initializes a directory
	 *
	 * @return void
	 */
	public function __construct() {
		$this->countries = array();
	}

	/**
	 * Set the specified date
	 *
	 * @param DateTime $date Date.
	 * @return void
	 */
	public function set_date( DateTime $date ) {
		$this->date = $date;
	}

	/**
	 * Add the specified country to this directory
	 *
	 * @param Country $country Country.
	 * @return void
	 */
	public function add_country( Country $country ) {
		$this->countries[] = $country;
	}

	/**
	 * Get the countries within this directory
	 *
	 * @return array<int, Country>
	 */
	public function get_countries() {
		return $this->countries;
	}
}
