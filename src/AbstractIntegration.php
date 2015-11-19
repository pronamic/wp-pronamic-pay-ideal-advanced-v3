<?php

abstract class Pronamic_WP_Pay_Gateways_IDealAdvancedV3_AbstractIntegration extends Pronamic_WP_Pay_Gateways_IDealAdvanced_AbstractIntegration {
	public function get_config_factory_class() {
		return 'Pronamic_WP_Pay_Gateways_IDealAdvancedV3_ConfigFactory';
	}

	public function get_config_class() {
		return 'Pronamic_WP_Pay_Gateways_IDealAdvancedV3_Config';
	}

	public function get_gateway_class() {
		return 'Pronamic_WP_Pay_Gateways_IDealAdvancedV3_Gateway';
	}
}
