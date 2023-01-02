<?php
/**
 * Status.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3;

/**
 * Title: Status
 * Description:
 * Copyright: 2005-2023 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 */
class Status {
	/**
	 * Status indicator for success
	 *
	 * @var string
	 */
	const SUCCESS = 'Success';

	/**
	 * Status indicator for cancelled
	 *
	 * @var string
	 */
	const CANCELLED = 'Cancelled';

	/**
	 * Status indicator for expired
	 *
	 * @var string
	 */
	const EXPIRED = 'Expired';

	/**
	 * Status indicator for failure
	 *
	 * @var string
	 */
	const FAILURE = 'Failure';

	/**
	 * Status indicator for open
	 *
	 * @var string
	 */
	const  OPEN = 'Open';
}
