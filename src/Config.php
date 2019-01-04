<?php

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3;

use Pronamic\WordPress\Pay\Core\GatewayConfig;

/**
 * Title: iDEAL Advanced config
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 * @since   1.0.0
 */
class Config extends GatewayConfig {
	public $merchant_id;

	public $sub_id = 0;

	public $private_key_password;

	public $private_key;

	public $private_certificate;

	public function get_payment_server_url() {
		return $this->payment_server_url;
	}

	public function get_certificates() {
		return array();
	}
}
