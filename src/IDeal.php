<?php

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3;

/**
 * Title: IDeal
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 */
class IDeal {
	/**
	 * Format the price according to the documentation
	 *
	 * @param float $amount
	 *
	 * @return string
	 */
	public static function format_amount( $amount ) {
		// The amount payable in euro (with a period (.) used as decimal separator)
		// page 18 - http://pronamic.nl/wp-content/uploads/2012/12/iDEAL-Merchant-Integration-Guide-ENG-v3.3.1.pdf
		return number_format( $amount, 2, '.', '' );
	}
}
