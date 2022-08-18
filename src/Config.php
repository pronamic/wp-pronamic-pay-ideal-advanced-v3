<?php
/**
 * Config.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3;

use JsonSerializable;
use Pronamic\WordPress\Pay\Core\GatewayConfig;

/**
 * Title: iDEAL Advanced config
 * Description:
 * Copyright: 2005-2022 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 * @since   1.0.0
 */
class Config extends GatewayConfig implements JsonSerializable {
	/**
	 * Merchant ID.
	 *
	 * @var string|null
	 */
	public $merchant_id;

	/**
	 * Sub ID.
	 *
	 * @var int|string|null
	 */
	public $sub_id = 0;

	/**
	 * Payment server URL.
	 *
	 * @var string|null
	 */
	public $payment_server_url;

	/**
	 * Private key password.
	 *
	 * @var string|null
	 */
	public $private_key_password;

	/**
	 * Private key.
	 *
	 * @var string|null
	 */
	public $private_key;

	/**
	 * Private certificate.
	 *
	 * @var string|null
	 */
	public $private_certificate;

	/**
	 * Purchase ID.
	 *
	 * @var string|null
	 */
	public $purchase_id;

	/**
	 * Get merchant ID.
	 *
	 * @return string|null
	 */
	public function get_merchant_id() {
		return $this->merchant_id;
	}

	/**
	 * Set merchant ID.
	 *
	 * @param string|null $merchant_id Merchant ID.
	 * @return void
	 */
	public function set_merchant_id( $merchant_id ) {
		$this->merchant_id = $merchant_id;
	}

	/**
	 * Get sub ID.
	 *
	 * @return int|string|null
	 */
	public function get_sub_id() {
		return $this->sub_id;
	}

	/**
	 * Set sub ID.
	 *
	 * @param int|string|null $sub_id Sub ID.
	 * @return void
	 */
	public function set_sub_id( $sub_id ) {
		$this->sub_id = $sub_id;
	}

	/**
	 * Get payment server URL.
	 *
	 * @return string|null
	 */
	public function get_payment_server_url() {
		return $this->payment_server_url;
	}

	/**
	 * Set payment server URL.
	 *
	 * @param string|null $payment_server_url Payment server URL.
	 * @return void
	 */
	public function set_payment_server_url( $payment_server_url ) {
		$this->payment_server_url = $payment_server_url;
	}

	/**
	 * Get private key password.
	 *
	 * @return string|null
	 */
	public function get_private_key_password() {
		return $this->private_key_password;
	}

	/**
	 * Set private key password.
	 *
	 * @param string|null $private_key_password Private key password.
	 * @return void
	 */
	public function set_private_key_password( $private_key_password ) {
		$this->private_key_password = $private_key_password;
	}

	/**
	 * Get private key.
	 *
	 * @return string|null
	 */
	public function get_private_key() {
		return $this->private_key;
	}

	/**
	 * Set private key.
	 *
	 * @param string|null $private_key Private key.
	 * @return void
	 */
	public function set_private_key( $private_key ) {
		$this->private_key = $private_key;
	}

	/**
	 * Get private certificate.
	 *
	 * @return string|null
	 */
	public function get_private_certificate() {
		return $this->private_certificate;
	}

	/**
	 * Set private certificate.
	 *
	 * @param string|null $private_certificate Private certificate.
	 * @return void
	 */
	public function set_private_certificate( $private_certificate ) {
		$this->private_certificate = $private_certificate;
	}

	/**
	 * Get purchase ID.
	 *
	 * @return string|null
	 */
	public function get_purchase_id() {
		return $this->purchase_id;
	}

	/**
	 * Set purchase ID.
	 *
	 * @param string|null $purchase_id Purchase ID.
	 * @return void
	 */
	public function set_purchase_id( $purchase_id ) {
		$this->purchase_id = $purchase_id;
	}

	/**
	 * Serialize to JSON.
	 *
	 * @link https://www.w3.org/TR/json-ld11/#specifying-the-type
	 * @return mixed|void
	 */
	public function jsonSerialize() {
		return [
			'@type'                => __CLASS__,
			'merchant_id'          => (string) $this->merchant_id,
			'sub_id'               => (string) $this->sub_id,
			'private_key'          => (string) $this->private_key,
			'private_key_password' => (string) $this->private_key_password,
			'private_certificate'  => (string) $this->private_certificate,
		];
	}
}
