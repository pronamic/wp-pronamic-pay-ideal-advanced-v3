<?php
/**
 * Issuer parser.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML;

use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\Issuer;
use SimpleXMLElement;

/**
 * Title: Issuer XML parser
 * Description:
 * Copyright: 2005-2023 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
class IssuerParser implements Parser {
	/**
	 * Parse
	 *
	 * @param SimpleXMLElement $xml    XML.
	 * @param Issuer           $issuer Issuer.
	 * @return Issuer
	 */
	public static function parse( SimpleXMLElement $xml, $issuer = null ) {
		if ( ! $issuer instanceof Issuer ) {
			$issuer = new Issuer();
		}

		$issuer->set_id( (string) $xml->issuerID );
		$issuer->set_name( (string) $xml->issuerName );
		$issuer->set_authentication_url( (string) $xml->issuerAuthenticationURL );

		return $issuer;
	}
}
