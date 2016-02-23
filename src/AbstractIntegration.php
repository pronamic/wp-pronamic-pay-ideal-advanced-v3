<?php

/**
 * Title: iDEAL Advanced v3 abstract integration
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.0.0
 */
abstract class Pronamic_WP_Pay_Gateways_IDealAdvancedV3_AbstractIntegration extends Pronamic_WP_Pay_Gateways_IDeal_AbstractIntegration {
	public function get_config_factory_class() {
		return 'Pronamic_WP_Pay_Gateways_IDealAdvancedV3_ConfigFactory';
	}

	public function get_config_class() {
		return 'Pronamic_WP_Pay_Gateways_IDealAdvancedV3_Config';
	}

	public function get_settings_class() {
		return array(
			'Pronamic_WP_Pay_Gateways_IDeal_Settings',
			'Pronamic_WP_Pay_Gateways_IDealAdvancedV3_Settings',
		);
	}

	/**
	 * Get required settings for this integration.
	 *
	 * @see https://github.com/wp-premium/gravityforms/blob/1.9.16/includes/fields/class-gf-field-multiselect.php#L21-L42
	 * @since 1.1.3
	 * @return array
	 */
	public function get_settings() {
		$settings = parent::get_settings();

		$settings[] = 'ideal-advanced-v3';

		return $settings;
	}
}
