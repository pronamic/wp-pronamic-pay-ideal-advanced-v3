<?php
use Pronamic\WordPress\Pay\Core\GatewayConfigFactory;

/**
 * Title: iDEAL Advanced v3 config factory
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 */
class Pronamic_WP_Pay_Gateways_IDealAdvancedV3_ConfigFactory extends GatewayConfigFactory {
	private $config_class;

	public function __construct( $config_class = 'Pronamic_WP_Pay_Gateways_IDealAdvancedV3_Config', $config_test_class = 'Pronamic_WP_Pay_Gateways_IDealAdvancedV3_Config' ) {
		$this->config_class      = $config_class;
		$this->config_test_class = $config_test_class;
	}

	public function get_config( $post_id ) {
		$mode = get_post_meta( $post_id, '_pronamic_gateway_mode', true );

		$config_class = ( 'test' === $mode ) ? $this->config_test_class : $this->config_class;

		$config = new $config_class();

		$config->merchant_id = get_post_meta( $post_id, '_pronamic_gateway_ideal_merchant_id', true );
		$config->sub_id      = get_post_meta( $post_id, '_pronamic_gateway_ideal_sub_id', true );
		$config->purchase_id = get_post_meta( $post_id, '_pronamic_gateway_ideal_purchase_id', true );

		$config->private_key          = get_post_meta( $post_id, '_pronamic_gateway_ideal_private_key', true );
		$config->private_key_password = get_post_meta( $post_id, '_pronamic_gateway_ideal_private_key_password', true );
		$config->private_certificate  = get_post_meta( $post_id, '_pronamic_gateway_ideal_private_certificate', true );

		return $config;
	}
}
