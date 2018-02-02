<?php

namespace Pronamic\WordPress\Pay\Gateways\IDeal_Advanced_V3\XML;

use Pronamic\WordPress\Pay\Gateways\IDeal_Advanced_V3\IDeal_Error;
use Pronamic\WordPress\Pay\Core\XML\Security;
use SimpleXMLElement;

/**
 * Title: iDEAL Advanced v3 error parser
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 */
class ErrorParser {
	/**
	 * Parse the specified XML element into an acquirer error response
	 *
	 * @param SimpleXMLElement $xml
	 *
	 * @return IDeal_Error|null
	 */
	public function parse( SimpleXMLElement $xml ) {
		$error = null;

		if ( 'Error' === $xml->getName() ) {
			$error = new IDeal_Error();

			$error->set_code( Security::filter( $xml->errorCode ) );
			$error->set_message( Security::filter( $xml->errorMessage ) );
			$error->set_detail( Security::filter( $xml->errorDetail ) );
			$error->set_suggested_action( Security::filter( $xml->suggestedAction ) );
			$error->set_consumer_message( Security::filter( $xml->consumerMessage ) );
		}

		return $error;
	}
}
