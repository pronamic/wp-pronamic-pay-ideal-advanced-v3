<?php

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3;

use Pronamic\WordPress\Pay\Gateways\IDeal\AbstractIntegration as IDeal_AbstractIntegration;

/**
 * Title: iDEAL Advanced v3 abstract integration
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 * @since   1.0.0
 */
abstract class AbstractIntegration extends IDeal_AbstractIntegration {
	public function get_config_factory_class() {
		return __NAMESPACE__ . '\ConfigFactory';
	}

	public function get_settings_class() {
		return array(
			'Pronamic\WordPress\Pay\Gateways\IDeal\Settings',
			__NAMESPACE__ . '\Settings',
		);
	}

	/**
	 * Get required settings for this integration.
	 *
	 * @see   https://github.com/wp-premium/gravityforms/blob/1.9.16/includes/fields/class-gf-field-multiselect.php#L21-L42
	 * @since 1.1.3
	 * @return array
	 */
	public function get_settings() {
		$settings = parent::get_settings();

		$settings[] = 'ideal-advanced-v3';

		return $settings;
	}
}
