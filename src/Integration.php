<?php

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3;

use Pronamic\WordPress\Pay\Gateways\IDeal\AbstractIntegration;

/**
 * Title: iDEAL Advanced v3 integration
 * Description:
 * Copyright: 2005-2019 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.0
 * @since   2.0.0
 */
class Integration extends AbstractIntegration {
	/**
	 * Settings constructor.
	 */
	public function __construct() {
		// Actions.
		add_action( 'current_screen', array( $this, 'maybe_download_private_certificate' ) );
		add_action( 'current_screen', array( $this, 'maybe_download_private_key' ) );
	}

	public function get_config_factory_class() {
		return __NAMESPACE__ . '\ConfigFactory';
	}

	public function get_settings_fields() {
		$fields = parent::get_settings_fields();

		/*
		 * Private Key and Certificate
		 */

		// Private key and certificate information.
		$fields[] = array(
			'section'  => 'ideal',
			'methods'  => array( 'ideal-advanced-v3' ),
			'title'    => __( 'Private key and certificate', 'pronamic_ideal' ),
			'type'     => 'description',
			'callback' => array( $this, 'field_security' ),
		);

		// Organization.
		$fields[] = array(
			'filter'   => FILTER_SANITIZE_STRING,
			'section'  => 'ideal',
			'methods'  => array( 'ideal-advanced-v3' ),
			'group'    => 'pk-cert',
			'meta_key' => '_pronamic_gateway_organization',
			'title'    => __( 'Organization', 'pronamic_ideal' ),
			'type'     => 'text',
			'tooltip'  => __( 'Organization name, e.g. Pronamic', 'pronamic_ideal' ),
		);

		// Organization Unit.
		$fields[] = array(
			'filter'   => FILTER_SANITIZE_STRING,
			'section'  => 'ideal',
			'methods'  => array( 'ideal-advanced-v3' ),
			'group'    => 'pk-cert',
			'meta_key' => '_pronamic_gateway_organization_unit',
			'title'    => __( 'Organization Unit', 'pronamic_ideal' ),
			'type'     => 'text',
			'tooltip'  => __( 'Organization unit, e.g. Administration', 'pronamic_ideal' ),
		);

		// Locality.
		$fields[] = array(
			'filter'   => FILTER_SANITIZE_STRING,
			'section'  => 'ideal',
			'methods'  => array( 'ideal-advanced-v3' ),
			'group'    => 'pk-cert',
			'meta_key' => '_pronamic_gateway_locality',
			'title'    => __( 'City', 'pronamic_ideal' ),
			'type'     => 'text',
			'tooltip'  => __( 'City, e.g. Amsterdam', 'pronamic_ideal' ),
		);

		// State or Province.
		$fields[] = array(
			'filter'   => FILTER_SANITIZE_STRING,
			'section'  => 'ideal',
			'methods'  => array( 'ideal-advanced-v3' ),
			'group'    => 'pk-cert',
			'meta_key' => '_pronamic_gateway_state_or_province',
			'title'    => __( 'State / province', 'pronamic_ideal' ),
			'type'     => 'text',
			'tooltip'  => __( 'State or province, e.g. Friesland', 'pronamic_ideal' ),
		);

		// Country.
		$locale = explode( '_', get_locale() );

		$locale = array_pop( $locale );

		$fields[] = array(
			'filter'      => FILTER_SANITIZE_STRING,
			'section'     => 'ideal',
			'methods'     => array( 'ideal-advanced-v3' ),
			'group'       => 'pk-cert',
			'meta_key'    => '_pronamic_gateway_country',
			'title'       => __( 'Country', 'pronamic_ideal' ),
			'type'        => 'text',
			'tooltip'     => sprintf(
				'%s %s (ISO-3166-1 alpha-2)',
				__( '2 letter country code, e.g.', 'pronamic_ideal' ),
				strtoupper( $locale )
			),
			'size'        => 2,
			'description' => sprintf(
				'%s %s',
				__( '2 letter country code, e.g.', 'pronamic_ideal' ),
				strtoupper( $locale )
			),
		);

		// Email Address.
		$fields[] = array(
			'filter'   => FILTER_SANITIZE_STRING,
			'section'  => 'ideal',
			'methods'  => array( 'ideal-advanced-v3' ),
			'group'    => 'pk-cert',
			'meta_key' => '_pronamic_gateway_email',
			'title'    => __( 'E-mail address', 'pronamic_ideal' ),
			'tooltip'  => sprintf(
				/* translators: %s: admin email */
				__( 'E-mail address, e.g. %s', 'pronamic_ideal' ),
				get_option( 'admin_email' )
			),
			'type'     => 'text',
		);

		// Number Days Valid.
		$fields[] = array(
			'filter'   => FILTER_SANITIZE_NUMBER_INT,
			'section'  => 'ideal',
			'methods'  => array( 'ideal-advanced-v3' ),
			'group'    => 'pk-cert',
			'meta_key' => '_pronamic_gateway_number_days_valid',
			'title'    => __( 'Number Days Valid', 'pronamic_ideal' ),
			'type'     => 'text',
			'default'  => 1825,
			'tooltip'  => __( 'Number of days the generated certificate will be valid for, e.g. 1825 days for the maximum duration of 5 years.', 'pronamic_ideal' ),
		);

		// Private Key Password.
		$fields[] = array(
			'filter'   => FILTER_SANITIZE_STRING,
			'section'  => 'ideal',
			'methods'  => array( 'ideal-advanced-v3' ),
			'group'    => 'pk-cert',
			'meta_key' => '_pronamic_gateway_ideal_private_key_password',
			'title'    => __( 'Private Key Password', 'pronamic_ideal' ),
			'type'     => 'text',
			'classes'  => array( 'regular-text', 'code' ),
			'default'  => wp_generate_password(),
			'tooltip'  => __( 'A random password which will be used for the generation of the private key and certificate.', 'pronamic_ideal' ),
		);

		// Private Key.
		$fields[] = array(
			'filter'   => FILTER_SANITIZE_STRING,
			'section'  => 'ideal',
			'methods'  => array( 'ideal-advanced-v3' ),
			'group'    => 'pk-cert',
			'meta_key' => '_pronamic_gateway_ideal_private_key',
			'title'    => __( 'Private Key', 'pronamic_ideal' ),
			'type'     => 'textarea',
			'callback' => array( $this, 'field_private_key' ),
			'classes'  => array( 'code' ),
			'tooltip'  => __( 'The private key is used for secure communication with the payment provider. If left empty, the private key will be generated using the given private key password.', 'pronamic_ideal' ),
		);

		// Private Certificate.
		$fields[] = array(
			'filter'   => FILTER_SANITIZE_STRING,
			'section'  => 'ideal',
			'methods'  => array( 'ideal-advanced-v3' ),
			'group'    => 'pk-cert',
			'meta_key' => '_pronamic_gateway_ideal_private_certificate',
			'title'    => __( 'Private Certificate', 'pronamic_ideal' ),
			'type'     => 'textarea',
			'callback' => array( $this, 'field_private_certificate' ),
			'classes'  => array( 'code' ),
			'tooltip'  => __( 'The certificate is used for secure communication with the payment provider. If left empty, the certificate will be generated using the private key and given organization details.', 'pronamic_ideal' ),
		);

		// Transaction feedback.
		$fields[] = array(
			'section' => 'ideal',
			'methods' => array( 'ideal-advanced-v3' ),
			'title'   => __( 'Transaction feedback', 'pronamic_ideal' ),
			'type'    => 'description',
			'html'    => __( 'Payment status updates will be processed without any additional configuration.', 'pronamic_ideal' ),
		);

		// Return.
		return $fields;
	}

	/**
	 * Field security
	 *
	 * @param array $field Field.
	 */
	public function field_security( $field ) {
		$certificate = get_post_meta( get_the_ID(), '_pronamic_gateway_ideal_private_certificate', true );

		?>
		<p>
			<?php if ( empty( $certificate ) ) : ?>

				<span
					class="dashicons dashicons-no"></span> <?php esc_html_e( 'The private key and certificate have not yet been configured.', 'pronamic_ideal' ); ?>
				<br/>

				<br/>

				<?php esc_html_e( 'A private key and certificate are required for communication with the payment provider. Enter the organization details from the iDEAL account below to generate these required files.', 'pronamic_ideal' ); ?>

			<?php else : ?>

				<span
					class="dashicons dashicons-yes"></span> <?php esc_html_e( 'A private key and certificate have been configured. The certificate must be uploaded to the payment provider dashboard to complete configuration.', 'pronamic_ideal' ); ?>
				<br/>

				<br/>

				<?php

				submit_button(
					__( 'Download certificate', 'pronamic_ideal' ),
					'secondary',
					'download_private_certificate',
					false
				);

				?>

				<a class="pronamic-pay-btn-link" href="#" id="pk-cert-fields-toggle"><?php esc_html_e( 'Show details…', 'pronamic_ideal' ); ?></a>

			<?php endif; ?>
		</p>
		<?php
	}

	/**
	 * Field private key.
	 *
	 * @param array $field Field.
	 */
	public function field_private_key( $field ) {
		$private_key          = get_post_meta( get_the_ID(), '_pronamic_gateway_ideal_private_key', true );
		$private_key_password = get_post_meta( get_the_ID(), '_pronamic_gateway_ideal_private_key_password', true );
		$number_days_valid    = get_post_meta( get_the_ID(), '_pronamic_gateway_number_days_valid', true );

		$filename = __( 'ideal.key', 'pronamic_ideal' );

		if ( ! empty( $private_key_password ) && ! empty( $number_days_valid ) ) {
			$command = sprintf(
				'openssl genrsa -aes128 -out %s -passout pass:%s 2048',
				escapeshellarg( $filename ),
				escapeshellarg( $private_key_password )
			);

			?>

			<p><?php esc_html_e( 'OpenSSL command', 'pronamic_ideal' ); ?></p>
			<input id="pronamic_ideal_openssl_command_key" name="pronamic_ideal_openssl_command_key" value="<?php echo esc_attr( $command ); ?>" type="text" class="large-text code" readonly="readonly"/>

			<?php
		} else {
			printf(
				'<p class="pronamic-pay-description description">%s</p>',
				esc_html__( 'Leave empty and save the configuration to generate the private key or view the OpenSSL command.', 'pronamic_ideal' )
			);
		}

		?>
		<p>
			<?php

			if ( ! empty( $private_key ) ) {
				submit_button(
					__( 'Download', 'pronamic_ideal' ),
					'secondary',
					'download_private_key',
					false
				);

				echo ' ';
			}

			printf(
				'<label class="pronamic-pay-form-control-file-button button">%s <input type="file" name="%s" /></label>',
				esc_html__( 'Upload', 'pronamic_ideal' ),
				'_pronamic_gateway_ideal_private_key_file'
			);

			?>
		</p>
		<?php
	}

	/**
	 * Field private certificate.
	 *
	 * @param array $field Field.
	 */
	public function field_private_certificate( $field ) {
		$certificate = get_post_meta( get_the_ID(), '_pronamic_gateway_ideal_private_certificate', true );

		$private_key_password = get_post_meta( get_the_ID(), '_pronamic_gateway_ideal_private_key_password', true );
		$number_days_valid    = get_post_meta( get_the_ID(), '_pronamic_gateway_number_days_valid', true );

		$filename_key = __( 'ideal.key', 'pronamic_ideal' );
		$filename_cer = __( 'ideal.cer', 'pronamic_ideal' );

		// @link http://www.openssl.org/docs/apps/req.html
		$subj_args = array(
			'C'            => get_post_meta( get_the_ID(), '_pronamic_gateway_country', true ),
			'ST'           => get_post_meta( get_the_ID(), '_pronamic_gateway_state_or_province', true ),
			'L'            => get_post_meta( get_the_ID(), '_pronamic_gateway_locality', true ),
			'O'            => get_post_meta( get_the_ID(), '_pronamic_gateway_organization', true ),
			'OU'           => get_post_meta( get_the_ID(), '_pronamic_gateway_organization_unit', true ),
			'CN'           => get_post_meta( get_the_ID(), '_pronamic_gateway_organization', true ),
			'emailAddress' => get_post_meta( get_the_ID(), '_pronamic_gateway_email', true ),
		);

		$subj_args = array_filter( $subj_args );

		$subj = '';
		foreach ( $subj_args as $type => $value ) {
			$subj .= '/' . $type . '=' . addslashes( $value );
		}

		if ( ! empty( $subj ) ) {
			$command = trim(
				sprintf(
					'openssl req -x509 -sha256 -new -key %s -passin pass:%s -days %s -out %s %s',
					escapeshellarg( $filename_key ),
					escapeshellarg( $private_key_password ),
					escapeshellarg( $number_days_valid ),
					escapeshellarg( $filename_cer ),
					empty( $subj ) ? '' : sprintf( '-subj %s', escapeshellarg( $subj ) )
				)
			);

			?>

			<p><?php esc_html_e( 'OpenSSL command', 'pronamic_ideal' ); ?></p>
			<input id="pronamic_ideal_openssl_command_certificate" name="pronamic_ideal_openssl_command_certificate" value="<?php echo esc_attr( $command ); ?>" type="text" class="large-text code" readonly="readonly"/>

			<?php
		} else {
			printf(
				'<p class="pronamic-pay-description description">%s</p>',
				esc_html__( 'Leave empty and save the configuration to generate the certificate or view the OpenSSL command.', 'pronamic_ideal' )
			);
		}

		if ( ! empty( $certificate ) ) {
			$fingerprint = Security::get_sha_fingerprint( $certificate );
			$fingerprint = str_split( $fingerprint, 2 );
			$fingerprint = implode( ':', $fingerprint );

			echo '<dl>';

			echo '<dt>', esc_html__( 'SHA Fingerprint', 'pronamic_ideal' ), '</dt>';
			echo '<dd>', esc_html( $fingerprint ), '</dd>';

			$info = openssl_x509_parse( $certificate );

			if ( $info ) {
				$date_format = __( 'M j, Y @ G:i', 'pronamic_ideal' );

				if ( isset( $info['validFrom_time_t'] ) ) {
					echo '<dt>', esc_html__( 'Valid From', 'pronamic_ideal' ), '</dt>';
					echo '<dd>', esc_html( date_i18n( $date_format, $info['validFrom_time_t'] ) ), '</dd>';
				}

				if ( isset( $info['validTo_time_t'] ) ) {
					echo '<dt>', esc_html__( 'Valid To', 'pronamic_ideal' ), '</dt>';
					echo '<dd>', esc_html( date_i18n( $date_format, $info['validTo_time_t'] ) ), '</dd>';
				}
			}

			echo '</dl>';
		}

		?>
		<p>
			<?php

			if ( ! empty( $certificate ) ) {
				submit_button(
					__( 'Download', 'pronamic_ideal' ),
					'secondary',
					'download_private_certificate',
					false
				);

				echo ' ';
			}

			printf(
				'<label class="pronamic-pay-form-control-file-button button">%s <input type="file" name="%s" /></label>',
				esc_html__( 'Upload', 'pronamic_ideal' ),
				'_pronamic_gateway_ideal_private_certificate_file'
			);

			?>
		</p>
		<?php
	}

	/**
	 * Download private certificate
	 */
	public function maybe_download_private_certificate() {
		if ( filter_has_var( INPUT_POST, 'download_private_certificate' ) ) {
			$post_id = filter_input( INPUT_POST, 'post_ID', FILTER_SANITIZE_STRING );

			$filename = sprintf( 'ideal-private-certificate-%s.cer', $post_id );

			header( 'Content-Description: File Transfer' );
			header( 'Content-Disposition: attachment; filename=' . $filename );
			header( 'Content-Type: application/x-x509-ca-cert; charset=' . get_option( 'blog_charset' ), true );

			echo get_post_meta( $post_id, '_pronamic_gateway_ideal_private_certificate', true ); // xss ok.

			exit;
		}
	}

	/**
	 * Download private key
	 */
	public function maybe_download_private_key() {
		if ( filter_has_var( INPUT_POST, 'download_private_key' ) ) {
			$post_id = filter_input( INPUT_POST, 'post_ID', FILTER_SANITIZE_STRING );

			$filename = sprintf( 'ideal-private-key-%s.key', $post_id );

			header( 'Content-Description: File Transfer' );
			header( 'Content-Disposition: attachment; filename=' . $filename );
			header( 'Content-Type: application/pgp-keys; charset=' . get_option( 'blog_charset' ), true );

			echo get_post_meta( $post_id, '_pronamic_gateway_ideal_private_key', true ); // xss ok.

			exit;
		}
	}

	/**
	 * Save post.
	 *
	 * @param array $data Data.
	 */
	public function save_post( $data ) {
		// Files.
		$files = array(
			'_pronamic_gateway_ideal_private_key_file' => '_pronamic_gateway_ideal_private_key',
			'_pronamic_gateway_ideal_private_certificate_file' => '_pronamic_gateway_ideal_private_certificate',
		);

		foreach ( $files as $name => $meta_key ) {
			if ( isset( $_FILES[ $name ] ) && UPLOAD_ERR_OK === $_FILES[ $name ]['error'] ) { // WPCS: input var okay.
				$value = file_get_contents( $_FILES[ $name ]['tmp_name'] ); // WPCS: input var okay. // WPCS: sanitization ok.

				$data[ $meta_key ] = $value;
			}
		}

		// Generate private key and certificate.
		if ( empty( $data['_pronamic_gateway_ideal_private_key_password'] ) ) {
			// Without private key password we can't create private key and certifiate.
			return $data;
		}

		if ( ! in_array( 'aes-128-cbc', openssl_get_cipher_methods(), true ) ) {
			// Without AES-128-CBC ciphter method we can't create private key and certificate.
			return $data;
		}

		// Private key.
		$pkey = openssl_pkey_get_private( $data['_pronamic_gateway_ideal_private_key'], $data['_pronamic_gateway_ideal_private_key_password'] );

		if ( false === $pkey ) {
			// If we can't open the private key we will create a new private key and certificate.
			if ( defined( 'OPENSSL_CIPHER_AES_128_CBC' ) ) {
				$cipher = OPENSSL_CIPHER_AES_128_CBC;
			} elseif ( defined( 'OPENSSL_CIPHER_3DES' ) ) {
				// @link https://www.pronamic.nl/wp-content/uploads/2011/12/iDEAL_Advanced_PHP_EN_V2.2.pdf
				$cipher = OPENSSL_CIPHER_3DES;
			} else {
				// Unable to create private key without cipher.
				return $data;
			}

			$args = array(
				'digest_alg'             => 'SHA256',
				'private_key_bits'       => 2048,
				'private_key_type'       => OPENSSL_KEYTYPE_RSA,
				'encrypt_key'            => true,
				'encrypt_key_cipher'     => $cipher,
				'subjectKeyIdentifier'   => 'hash',
				'authorityKeyIdentifier' => 'keyid:always,issuer:always',
				'basicConstraints'       => 'CA:true',
			);

			$pkey = openssl_pkey_new( $args );

			if ( false === $pkey ) {
				return $data;
			}

			// Export key.
			$result = openssl_pkey_export( $pkey, $private_key, $data['_pronamic_gateway_ideal_private_key_password'], $args );

			if ( false === $result ) {
				return $data;
			}

			$data['_pronamic_gateway_ideal_private_key'] = $private_key;
			// Delete private certificate since this is no longer valid.
			$data['_pronamic_gateway_ideal_private_certificate'] = null;
		}

		// Certificate.
		if ( empty( $data['_pronamic_gateway_ideal_private_certificate'] ) ) {
			$required_keys = array(
				'countryName',
				'stateOrProvinceName',
				'localityName',
				'organizationName',
				'commonName',
				'emailAddress',
			);

			$distinguished_name = array(
				'countryName'            => $data['_pronamic_gateway_country'],
				'stateOrProvinceName'    => $data['_pronamic_gateway_state_or_province'],
				'localityName'           => $data['_pronamic_gateway_locality'],
				'organizationName'       => $data['_pronamic_gateway_organization'],
				'organizationalUnitName' => $data['_pronamic_gateway_organization_unit'],
				'commonName'             => $data['_pronamic_gateway_organization'],
				'emailAddress'           => $data['_pronamic_gateway_email'],
			);

			$distinguished_name = array_filter( $distinguished_name );

			/*
			 * Create certificate only if distinguished name contains all required elements
			 *
			 * @link http://stackoverflow.com/questions/13169588/how-to-check-if-multiple-array-keys-exists
			 */
			if ( count( array_intersect_key( array_flip( $required_keys ), $distinguished_name ) ) === count( $required_keys ) ) {
				$csr = openssl_csr_new( $distinguished_name, $pkey );

				$cert = openssl_csr_sign( $csr, null, $pkey, $data['_pronamic_gateway_number_days_valid'], $args, time() );

				openssl_x509_export( $cert, $certificate );

				$data['_pronamic_gateway_ideal_private_certificate'] = $certificate;
			}
		}

		return $data;
	}
}
