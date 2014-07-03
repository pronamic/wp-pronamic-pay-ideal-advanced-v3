<?php

/**
 * Title: iDEAL Advanced v3 error parser
 * Description:
 * Copyright: Copyright (c) 2005 - 2014
 * Company: Pronamic
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

		if ( 'Error' == $xml->getName() ) {
			$error = new Pronamic_WP_Pay_Gateways_IDealAdvancedV3_Error();

			$error->set_code( (string) $xml->errorCode );
			$error->set_message( (string) $xml->errorMessage );
			$error->set_detail( (string) $xml->errorDetail );
			$error->set_suggested_action( (string) $xml->suggestedAction );
			$error->set_consumer_message( (string) $xml->consumerMessage );
		}

		return $error;
	}
}
