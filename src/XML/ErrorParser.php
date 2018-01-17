<?php

/**
 * Title: iDEAL Advanced v3 error parser
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 */
class Pronamic_WP_Pay_Gateways_IDealAdvancedV3_XML_ErrorParser {
	/**
	 * Parse the specified XML element into an acquirer error response
	 *
	 * @param SimpleXMLElement $xml
	 */
	public function parse( SimpleXMLElement $xml ) {
		$error = null;

		if ( 'Error' === $xml->getName() ) {
			$error = new Pronamic_WP_Pay_Gateways_IDealAdvancedV3_Error();

			$error->set_code( Pronamic_WP_Pay_XML_Security::filter( $xml->errorCode ) );
			$error->set_message( Pronamic_WP_Pay_XML_Security::filter( $xml->errorMessage ) );
			$error->set_detail( Pronamic_WP_Pay_XML_Security::filter( $xml->errorDetail ) );
			$error->set_suggested_action( Pronamic_WP_Pay_XML_Security::filter( $xml->suggestedAction ) );
			$error->set_consumer_message( Pronamic_WP_Pay_XML_Security::filter( $xml->consumerMessage ) );
		}

		return $error;
	}
}
