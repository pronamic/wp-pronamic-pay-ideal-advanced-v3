<?php
/**
 * Error parser test.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML;

use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * Title: iDEAL Advanced v3 XML error parser test
 * Description:
 * Copyright: 2005-2022 Pronamic
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 */
class ErrorParserTest extends TestCase {
	/**
	 * Test parser.
	 *
	 * @return void
	 */
	public function testParser() {
		$parser = new ErrorParser();

		$xml = simplexml_load_file( dirname( dirname( dirname( __FILE__ ) ) ) . '/Mock/Error.xml' );

		$error = $parser->parse( $xml );

		$string = (string) $error;

		$this->assertInstanceOf( '\Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\Error', $error );
		$this->assertSame( 'SO1100', $error->get_code() );
		$this->assertSame( 'Issuer not available', $error->get_message() );
		$this->assertSame( 'System generating error: Rabobank', $error->get_detail() );
		$this->assertSame( null, $error->get_suggested_action() );
		$this->assertSame( 'De geselecteerde iDEAL bank is momenteel niet beschikbaar i.v.m. onderhoud tot naar verwachting 31-12-2010 03:30. Probeer het later nogmaals of betaal op een andere manier.', $error->get_consumer_message() );
	}
}
