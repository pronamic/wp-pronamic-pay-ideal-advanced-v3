<?php
/**
 * Error test.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3;

use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * Title: iDEAL Advanced v3 error test
 * Description:
 * Copyright: 2005-2024 Pronamic
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 */
class ErrorTest extends TestCase {
	/**
	 * Test error to string.
	 */
	public function test_error() {
		$error = new Error(
			'AP9901',
			'merchantID not found in XML data. Please validate your XML.',
			'merchantID not found in XML data. Please validate your XML.',
			'Please try again later or pay using another payment method.',
			'Betalen met iDEAL is nu niet mogelijk. Probeer het later nogmaals of betaal op een andere manier.'
		);

		$this->assertEquals( 'AP9901', $error->get_code() );
		$this->assertEquals( 'merchantID not found in XML data. Please validate your XML.', $error->get_message() );
		$this->assertEquals( 'merchantID not found in XML data. Please validate your XML.', $error->get_detail() );
		$this->assertEquals( 'Please try again later or pay using another payment method.', $error->get_suggested_action() );
		$this->assertEquals( 'Betalen met iDEAL is nu niet mogelijk. Probeer het later nogmaals of betaal op een andere manier.', $error->get_consumer_message() );
	}
}
