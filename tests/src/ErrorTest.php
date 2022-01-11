<?php
/**
 * Error test.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3;

use PHPUnit_Framework_TestCase;

/**
 * Title: iDEAL Advanced v3 error test
 * Description:
 * Copyright: 2005-2022 Pronamic
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 */
class ErrorTest extends PHPUnit_Framework_TestCase {
	/**
	 * Test error to string.
	 */
	public function testToStringError() {
		$error = new Error();
		$error->set_code( '1' );
		$error->set_message( 'Error' );

		$string = (string) $error;

		$expected = '1 Error';

		$this->assertEquals( $expected, $string );
	}
}
