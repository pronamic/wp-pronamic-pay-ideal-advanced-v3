<?php
use Pronamic\WordPress\Pay\Core\GatewayConfig;

/**
 * Title: iDEAL Advanced config
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.1.3
 * @since 1.0.0
 */
class Pronamic_WP_Pay_Gateways_IDealAdvancedV3_Config extends GatewayConfig {
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

	public function get_gateway_class() {
		return 'Pronamic_WP_Pay_Gateways_IDealAdvancedV3_Gateway';
	}
}
