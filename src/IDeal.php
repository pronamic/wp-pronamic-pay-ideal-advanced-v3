<?php
/**
 * IDEAL utils.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3;

/**
 * Title: IDeal
 * Description:
 * Copyright: 2005-2021 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
class IDeal {
	/**
	 * Format the price according to the documentation
	 *
	 * @param float $amount Amount.
	 * @return string
	 */
	public static function format_amount( $amount ) {
		/**
		 * The amount payable in euro (with a period (.) used as decimal separator).
		 *
		 * @link (page 18) http://pronamic.nl/wp-content/uploads/2012/12/iDEAL-Merchant-Integration-Guide-ENG-v3.3.1.pdf
		 */
		return number_format( $amount, 2, '.', '' );
	}
}
