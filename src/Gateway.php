<?php
/**
 * Gateway.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3;

use Pronamic\WordPress\Pay\Banks\BankAccountDetails;
use Pronamic\WordPress\Pay\Core\Gateway as Core_Gateway;
use Pronamic\WordPress\Pay\Core\PaymentMethod;
use Pronamic\WordPress\Pay\Core\PaymentMethods;
use Pronamic\WordPress\Pay\Fields\CachedCallbackOptions;
use Pronamic\WordPress\Pay\Fields\IDealIssuerSelectField;
use Pronamic\WordPress\Pay\Fields\SelectFieldOption;
use Pronamic\WordPress\Pay\Fields\SelectFieldOptionGroup;
use Pronamic\WordPress\Pay\Payments\Payment;

/**
 * Title: iDEAL Advanced v3+ gateway
 * Description:
 * Copyright: 2005-2023 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.5
 * @since   1.0.0
 */
class Gateway extends Core_Gateway {
	/**
	 * Client.
	 *
	 * @var Client
	 */
	protected $client;

	/**
	 * Config.
	 *
	 * @var Config
	 */
	protected $config;

	/**
	 * Mode.
	 *
	 * @var string
	 */
	public $mode = 'live';

	/**
	 * Constructs and initializes an iDEAL Advanced v3 gateway
	 *
	 * @param Config $config Config.
	 */
	public function __construct( Config $config ) {
		parent::__construct();

		$this->config = $config;

		$this->set_method( self::METHOD_HTTP_REDIRECT );

		// Supported features.
		$this->supports = [
			'payment_status_request',
		];

		// Methods.
		$ideal_payment_method = new PaymentMethod( PaymentMethods::IDEAL );
		$ideal_payment_method->set_status( 'active' );

		$ideal_issuer_field = new IDealIssuerSelectField( 'ideal-issuer' );

		$ideal_issuer_field->set_required( true );

		$ideal_issuer_field->set_options(
			new CachedCallbackOptions(
				function() {
					return $this->get_ideal_issuers();
				},
				'pronamic_pay_ideal_issuers_' . \md5( (string) \wp_json_encode( $config ) )
			)
		);

		$ideal_payment_method->add_field( $ideal_issuer_field );

		$this->register_payment_method( $ideal_payment_method );

		// Client.
		$client = new Client();

		$client->set_acquirer_url( (string) $config->get_payment_server_url() );

		$client->merchant_id          = (string) $config->get_merchant_id();
		$client->sub_id               = (string) $config->get_sub_id();
		$client->private_key          = (string) $config->get_private_key();
		$client->private_key_password = (string) $config->get_private_key_password();
		$client->certificate          = (string) $config->get_certificate();

		$this->client = $client;
	}

	/**
	 * Get iDEAL issuers.
	 *
	 * @return SelectFieldOptionGroup[]
	 */
	private function get_ideal_issuers() {
		$groups = [];

		$directory = $this->client->get_directory();

		if ( null === $directory ) {
			return $groups;
		}

		foreach ( $directory->get_countries() as $country ) {
			$group = new SelectFieldOptionGroup( $country->get_name() );

			foreach ( $country->get_issuers() as $issuer ) {
				$id   = $issuer->get_id();
				$name = $issuer->get_name();

				if ( null === $id || null === $name ) {
					continue;
				}

				$group->options[] = new SelectFieldOption( $id, $name );
			}

			$groups[] = $group;
		}

		return $groups;
	}

	/**
	 * Start
	 *
	 * @see Core_Gateway::start()
	 *
	 * @param Payment $payment Payment.
	 * @throws \Exception Throws exception on unsupported payment method.
	 */
	public function start( Payment $payment ) {
		/**
		 * If the payment method of the payment is unknown (`null`), we will turn it into
		 * an iDEAL payment.
		 */
		$payment_method = $payment->get_payment_method();

		if ( null === $payment_method ) {
			$payment->set_payment_method( PaymentMethods::IDEAL );
		}

		/**
		 * This gateway can only process payments for the payment method iDEAL.
		 */
		$payment_method = $payment->get_payment_method();

		if ( PaymentMethods::IDEAL !== $payment_method ) {
			throw new \Exception(
				\sprintf(
					'The iDEAL Advanced gateway cannot process `%s` payments, only iDEAL payments.',
					$payment_method
				)
			);
		}

		// Purchase ID.
		$purchase_id = $payment->format_string( (string) $this->config->get_purchase_id() );

		if ( '' === $purchase_id ) {
			$purchase_id = $payment->get_id();
		}

		$payment->set_meta( 'purchase_id', $purchase_id );

		/**
		 * The Transaction.entranceCode is an 'authentication identifier' to
		 * facilitate continuation of the session between Merchant and Consumer,
		 * even if the existing session has been lost. It enables the Merchant to
		 * recognise the Consumer associated with a (completed) transaction.
		 * The Transaction.entranceCode is sent to the Merchant in the Redirect.
		 * The Transaction.entranceCode must have a minimum variation of 1
		 * million and should comprise letters and/or figures (maximum 40
		 * positions).
		 * The Transaction.entranceCode is created by the Merchant and passed
		 * to the Issuer.
		 *
		 * @link https://www.pronamic.eu/wp-content/uploads/sites/2/2016/06/Merchant-Integration-Guide-v3-3-1-ENG-February-2015.pdf
		 */
		$entrance_code = \wp_generate_password( 40, false );

		$payment->set_meta( 'entrance_code', $entrance_code );

		// Transaction.
		$transaction = new Transaction();
		$transaction->set_purchase_id( $purchase_id );
		$transaction->set_amount( $payment->get_total_amount()->number_format( null, '.', '' ) );
		$transaction->set_currency( $payment->get_total_amount()->get_currency()->get_alphabetic_code() );
		$transaction->set_expiration_period( 'PT30M' );
		$transaction->set_description( $payment->get_description() );
		$transaction->set_entrance_code( $entrance_code );

		$customer = $payment->get_customer();

		if ( null !== $customer ) {
			$transaction->set_language( $customer->get_language() );
		}

		// Create transaction.
		$result = $this->client->create_transaction( $transaction, $payment->get_return_url(), (string) $payment->get_meta( 'issuer' ) );

		if ( null !== $result->issuer ) {
			$authentication_url = $result->issuer->get_authentication_url();

			if ( null !== $authentication_url ) {
				$payment->set_action_url( $authentication_url );
			}
		}

		if ( null !== $result->transaction ) {
			$payment->set_transaction_id( $result->transaction->get_id() );
		}
	}

	/**
	 * Update status of the specified payment
	 *
	 * @param Payment $payment Payment.
	 */
	public function update_status( Payment $payment ) {
		$transaction_id = (string) $payment->get_transaction_id();

		// Try to retrieve payment status.
		try {
			$result = $this->client->get_status( $transaction_id );
		} catch ( \Exception $e ) {
			$note = sprintf(
				/* translators: %s: exception message */
				__( 'Error getting payment status: %s', 'pronamic_ideal' ),
				$e->getMessage()
			);

			$payment->add_note( $note );

			return;
		}

		// Check transaction result.
		if ( null === $result->transaction ) {
			return;
		}

		// Update payment with transaction data.
		$transaction = $result->transaction;

		$payment->set_status( $transaction->get_status() );

		$consumer_bank_details = $payment->get_consumer_bank_details();

		if ( null === $consumer_bank_details ) {
			$consumer_bank_details = new BankAccountDetails();

			$payment->set_consumer_bank_details( $consumer_bank_details );
		}

		$consumer_bank_details->set_name( $transaction->get_consumer_name() );
		$consumer_bank_details->set_iban( $transaction->get_consumer_iban() );
		$consumer_bank_details->set_bic( $transaction->get_consumer_bic() );
	}

	/**
	 * Get mode.
	 *
	 * @return string
	 */
	public function get_mode() {
		return $this->mode;
	}
}
