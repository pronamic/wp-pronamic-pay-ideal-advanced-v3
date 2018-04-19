<?php

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3;

use Pronamic\WordPress\Pay\Core\Gateway as Core_Gateway;
use Pronamic\WordPress\Pay\Core\PaymentMethods;
use Pronamic\WordPress\Pay\Payments\Payment;

/**
 * Title: iDEAL Advanced v3+ gateway
 * Description:
 * Copyright: Copyright (c) 2005 - 2018
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 1.1.5
 * @since   1.0.0
 */
class Gateway extends Core_Gateway {
	/**
	 * Constructs and initializes an iDEAL Advanced v3 gateway
	 *
	 * @param Config $config
	 */
	public function __construct( Config $config ) {
		parent::__construct( $config );

		$this->supports = array(
			'payment_status_request',
		);

		$this->set_method( Gateway::METHOD_HTTP_REDIRECT );
		$this->set_has_feedback( true );
		$this->set_amount_minimum( 0.01 );

		// Client
		$client = new Client();

		$client->set_acquirer_url( $config->get_payment_server_url() );

		$client->merchant_id          = $config->merchant_id;
		$client->sub_id               = $config->sub_id;
		$client->private_key          = $config->private_key;
		$client->private_key_password = $config->private_key_password;
		$client->private_certificate  = $config->private_certificate;

		$this->client = $client;
	}

	/**
	 * Get issuers
	 *
	 * @see Core_Gateway::get_issuers()
	 *
	 * @return array
	 */
	public function get_issuers() {
		$directory = $this->client->get_directory();

		if ( ! $directory ) {
			$this->error = $this->client->get_error();

			return array();
		}

		$groups = array();

		foreach ( $directory->get_countries() as $country ) {
			$issuers = array();

			foreach ( $country->get_issuers() as $issuer ) {
				$issuers[ $issuer->get_id() ] = $issuer->get_name();
			}

			$groups[] = array(
				'name'    => $country->get_name(),
				'options' => $issuers,
			);
		}

		return $groups;
	}

	public function get_issuer_field() {
		if ( PaymentMethods::IDEAL === $this->get_payment_method() ) {
			return array(
				'id'       => 'pronamic_ideal_issuer_id',
				'name'     => 'pronamic_ideal_issuer_id',
				'label'    => __( 'Choose your bank', 'pronamic_ideal' ),
				'required' => true,
				'type'     => 'select',
				'choices'  => $this->get_transient_issuers(),
			);
		}
	}

	/**
	 * Get supported payment methods
	 *
	 * @see Pronamic_WP_Pay_Gateway::get_supported_payment_methods()
	 */
	public function get_supported_payment_methods() {
		return array(
			PaymentMethods::IDEAL,
		);
	}

	/**
	 * Is payment method required to start transaction?
	 *
	 * @see   Core_Gateway::payment_method_is_required()
	 * @since 1.1.5
	 */
	public function payment_method_is_required() {
		return true;
	}

	/**
	 * Start
	 *
	 * @see Pronamic_WP_Pay_Gateway::start()
	 */
	public function start( Payment $payment ) {
		// Purchase ID
		$purchase_id = $payment->format_string( $this->config->purchase_id );

		$payment->set_meta( 'purchase_id', $purchase_id );

		// Transaction
		$transaction = new Transaction();
		$transaction->set_purchase_id( $purchase_id );
		$transaction->set_amount( $payment->get_amount()->get_amount() );
		$transaction->set_currency( $payment->get_currency() );
		$transaction->set_expiration_period( 'PT30M' );
		$transaction->set_language( $payment->get_language() );
		$transaction->set_description( $payment->get_description() );
		$transaction->set_entrance_code( $payment->get_entrance_code() );

		$result = $this->client->create_transaction( $transaction, $payment->get_return_url(), $payment->get_issuer() );

		$error = $this->client->get_error();

		if ( is_wp_error( $error ) ) {
			$this->set_error( $error );

			return;
		}

		$payment->set_action_url( $result->issuer->get_authentication_url() );
		$payment->set_transaction_id( $result->transaction->get_id() );
	}

	/**
	 * Update status of the specified payment
	 *
	 * @param Payment $payment
	 */
	public function update_status( Payment $payment ) {
		$result = $this->client->get_status( $payment->get_transaction_id() );

		$error = $this->client->get_error();

		if ( is_wp_error( $error ) ) {
			$this->set_error( $error );
		} else {
			$transaction = $result->transaction;

			$payment->set_status( $transaction->get_status() );
			$payment->set_consumer_name( $transaction->get_consumer_name() );
			$payment->set_consumer_iban( $transaction->get_consumer_iban() );
			$payment->set_consumer_bic( $transaction->get_consumer_bic() );
		}
	}
}
