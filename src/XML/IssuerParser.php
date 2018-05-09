<?php

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML;

use Pronamic\WordPress\Pay\Core\XML\Security;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\Issuer;
use SimpleXMLElement;

/**
 * Title: Issuer XML parser
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
class IssuerParser implements Parser {
	/**
	 * Parse
	 *
	 * @param SimpleXMLElement $xml
	 * @param Issuer           $issuer
	 *
	 * @return Issuer
	 */
	public static function parse( SimpleXMLElement $xml, $issuer = null ) {
		if ( ! $issuer instanceof Issuer ) {
			$issuer = new Issuer();
		}

		if ( $xml->issuerID ) {
			$issuer->set_id( Security::filter( $xml->issuerID ) );
		}

		if ( $xml->issuerName ) {
			$issuer->set_name( Security::filter( $xml->issuerName ) );
		}

		if ( $xml->issuerAuthenticationURL ) {
			$issuer->set_authentication_url( Security::filter( $xml->issuerAuthenticationURL ) );
		}

		return $issuer;
	}
}
