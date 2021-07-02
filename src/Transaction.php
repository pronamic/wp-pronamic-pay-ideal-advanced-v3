<?php
/**
 * Transaction.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3;

/**
 * Title: Transaction
 * Description:
 * Copyright: 2005-2021 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
class Transaction {
	/**
	 * Transaction ID
	 *
	 * @var string|null
	 */
	private $id;

	/**
	 * Purchase ID
	 *
	 * @var string|null
	 */
	private $purchase_id;

	/**
	 * Amount
	 *
	 * @var string|null
	 */
	private $amount;

	/**
	 * Currency
	 *
	 * @var string|null
	 */
	private $currency;

	/**
	 * Timeframe during which the transaction is allowed to take
	 * place. Notation PnYnMnDTnHnMnS, where every n
	 * indicates the number of years, months, days, hours, minutes
	 * and seconds respectively. E.g. PT1H indicates an expiration
	 * period of 1 hour. PT3M30S indicates a period of 3 and a half
	 * minutes. Maximum allowed is PT1H; minimum allowed is
	 * PT1M.
	 *
	 * @var string|null
	 */
	private $expiration_period;

	/**
	 * Language
	 *
	 * @var string|null
	 */
	private $language;

	/**
	 * Description
	 *
	 * @var string|null
	 */
	private $description;

	/**
	 * Mandatory code to identify the customer when he/she is
	 * redirected back to the merchantReturnURL
	 *
	 * @var string|null
	 */
	private $entrance_code;

	/**
	 * The status of this transaction
	 *
	 * @var string|null
	 */
	private $status;

	/**
	 * The consumer name
	 *
	 * @var string|null
	 */
	private $consumer_name;

	/**
	 * Consumer IBAN
	 *
	 * @var string|null
	 */
	private $consumer_iban;

	/**
	 * Consumer BIC
	 *
	 * @var string|null
	 */
	private $consumer_bic;

	/**
	 * Constructs and initializes an transaction
	 *
	 * @return void
	 */
	public function __construct() {
	}

	/**
	 * Get the ID of this transaction
	 *
	 * @return string|null
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Set the ID of this transaction
	 *
	 * @param string|null $id Transaction ID.
	 * @return void
	 */
	public function set_id( $id ) {
		$this->id = $id;
	}

	/**
	 * Get the purchase ID of this transaction
	 *
	 * The purchase number according to the online shop’s system
	 *
	 * @return string|null
	 */
	public function get_purchase_id() {
		return $this->purchase_id;
	}

	/**
	 * Set the purchase id of this transaction
	 *
	 * The purchase number according to the online shop’s system
	 *
	 * @param string|null $id Purchase ID.
	 * @return void
	 */
	public function set_purchase_id( $id ) {
		$this->purchase_id = $id;
	}

	/**
	 * Get the amount of this transaction
	 *
	 * @return string|null
	 */
	public function get_amount() {
		return $this->amount;
	}

	/**
	 * Set the amount of this transaction
	 *
	 * @param string|null $amount Amount.
	 * @return void
	 */
	public function set_amount( $amount ) {
		$this->amount = $amount;
	}

	/**
	 * Get the currency of this transaction
	 *
	 * @return string|null
	 */
	public function get_currency() {
		return $this->currency;
	}

	/**
	 * Set the currency of this transaction
	 *
	 * @param string|null $currency Currency.
	 * @return void
	 */
	public function set_currency( $currency ) {
		$this->currency = $currency;
	}

	/**
	 * Get the expiration period of this transaction
	 *
	 * @return string|null
	 */
	public function get_expiration_period() {
		return $this->expiration_period;
	}

	/**
	 * Set the expiration period of this transaction
	 *
	 * @param string|null $expiration_period Expiration period in date interval specification notation (e.g. `PT30M`).
	 * @return void
	 */
	public function set_expiration_period( $expiration_period ) {
		$this->expiration_period = $expiration_period;
	}

	/**
	 * Get the language of this transaction
	 *
	 * @return string|null
	 */
	public function get_language() {
		return $this->language;
	}

	/**
	 * Set the language of this transaction
	 *
	 * @param string|null $language Language.
	 * @return void
	 */
	public function set_language( $language ) {
		$this->language = $language;
	}

	/**
	 * Get the description of this transaction
	 *
	 * @return string|null
	 */
	public function get_description() {
		return $this->description;
	}

	/**
	 * Set the description of this transaction
	 * AN..max32 (AN = Alphanumerical, free text)
	 *
	 * @param string|null $description Description.
	 * @return void
	 */
	public function set_description( $description ) {
		if ( null !== $description ) {
			$description = substr( $description, 0, 32 );
		}

		$this->description = $description;
	}

	/**
	 * Get the entrance code of this transaction
	 *
	 * A code determined by the online shop with which the purchase can be
	 * authenticated upon redirection to the online shop (see section 4.2.2
	 * for details).
	 *
	 * @return string|null
	 */
	public function get_entrance_code() {
		return $this->entrance_code;
	}

	/**
	 * Set the entrance code
	 * ANS..max40 (ANS = Strictly alphanumerical (letters and numbers only))
	 *
	 * A code determined by the online shop with which the purchase can be
	 * authenticated upon redirection to the online shop (see section 4.2.2
	 * for details).
	 *
	 * @param string|null $entrance_code Entrance code.
	 * @return void
	 */
	public function set_entrance_code( $entrance_code ) {
		if ( null !== $entrance_code ) {
			$entrance_code = substr( $entrance_code, 0, 40 );
		}

		$this->entrance_code = $entrance_code;
	}

	/**
	 * Get the status of this transaction
	 *
	 * @return string|null
	 */
	public function get_status() {
		return $this->status;
	}

	/**
	 * Set the status
	 *
	 * @param string|null $status Status.
	 * @return void
	 */
	public function set_status( $status ) {
		$this->status = $status;
	}

	/**
	 * Get the consumer name
	 *
	 * @return string|null
	 */
	public function get_consumer_name() {
		return $this->consumer_name;
	}

	/**
	 * Set the consumer name
	 *
	 * @param string|null $name Consumer name.
	 * @return void
	 */
	public function set_consumer_name( $name ) {
		$this->consumer_name = $name;
	}

	/**
	 * Get the consumer IBAN number
	 *
	 * @return string|null
	 */
	public function get_consumer_iban() {
		return $this->consumer_iban;
	}

	/**
	 * Set the consumer IBAN number
	 *
	 * @param string|null $iban Consumer IBAN.
	 * @return void
	 */
	public function set_consumer_iban( $iban ) {
		$this->consumer_iban = $iban;
	}

	/**
	 * Get the consumer BIC number
	 *
	 * @return string|null
	 */
	public function get_consumer_bic() {
		return $this->consumer_bic;
	}

	/**
	 * Set the consumer BIC number
	 *
	 * @param string|null $bic Consumer BIC.
	 * @return void
	 */
	public function set_consumer_bic( $bic ) {
		$this->consumer_bic = $bic;
	}
}
