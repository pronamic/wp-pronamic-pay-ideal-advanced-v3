<?php

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3;

use PHPUnit_Framework_TestCase;

/**
 * Title: iDEAL Advanced v3 error test
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 */
class ErrorTest extends PHPUnit_Framework_TestCase {
	public function testToStringError() {
		$error = new Error();
		$error->set_code( '1' );
		$error->set_message( 'Error' );

		$string = (string) $error;

		$expected = '1 Error';

		$this->assertEquals( $expected, $string );
	}
}
