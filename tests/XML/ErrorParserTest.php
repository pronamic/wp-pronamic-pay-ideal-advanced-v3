<?php

/**
 * Title: iDEAL Advanced v3 XML error parser test
 * Description:
 * Copyright: Copyright (c) 2005 - 2015
 * Company: Pronamic
 * @author Remco Tolsma
 * @version 1.0.0
 */
class Pronamic_WP_Pay_Gateways_IDealAdvancedV3_XML_ErrorParserTest extends PHPUnit_Framework_TestCase {
	public function testParser() {
		$parser = new Pronamic_WP_Pay_Gateways_IDealAdvancedV3_XML_ErrorParser();

		$xml = simplexml_load_file( dirname( __FILE__ ) . '/../Mock/Error.xml' );

		$error = $parser->parse( $xml );

		$string = (string) $error;

		$this->assertInstanceOf( 'Pronamic_WP_Pay_Gateways_IDealAdvancedV3_Error', $error );
		$this->assertSame( 'SO1100', $error->get_code() );
		$this->assertSame( 'Issuer not available', $error->get_message() );
		$this->assertSame( 'System generating error: Rabobank', $error->get_detail() );
		$this->assertSame( null, $error->get_suggested_action() );
		$this->assertSame( 'De geselecteerde iDEAL bank is momenteel niet beschikbaar i.v.m. onderhoud tot naar verwachting 31-12-2010 03:30. Probeer het later nogmaals of betaal op een andere manier.', $error->get_consumer_message() );
	}
}
