<?php

/**
 * Title: iDEAL Advanced v3 gateway settings
 * Description:
 * Copyright: Copyright (c) 2005 - 2016
 * Company: Pronamic
 *
 * @author Remco Tolsma
 * @version 1.1.3
 * @since 1.1.2
 */
class Pronamic_WP_Pay_Gateways_IDealAdvancedV3_Settings extends Pronamic_WP_Pay_GatewaySettings {
	public function __construct() {
		// Filters
		add_filter( 'pronamic_pay_gateway_fields', array( $this, 'fields' ) );

		// Actions
		add_action( 'admin_init', array( $this, 'maybe_download_private_certificate' ) );
		add_action( 'admin_init', array( $this, 'maybe_download_private_key' ) );
	}

	public function fields( array $fields ) {
		/*
		 * Private Key and Certificate
		 */

		// Private key and certificate information
		$fields[] = array(
			'section'     => 'ideal',
			'methods'     => array( 'ideal-advanced-v3' ),
			'title'       => __( 'Private key and certificate', 'pronamic_ideal' ),
			'type'        => 'description',
			'html'        => sprintf(
				'<div class="pk-cert-error"><span class="dashicons dashicons-no pronamic-pay-no"></span> %s</div> <div class="pk-cert-ok"><span class="dashicons dashicons-yes pronamic-pay-yes"></span> %s</div>',
				__( '<span>The private key and certificate have not yet been configured.</span><p>A private key and certificate are required for communication with the payment provider. Enter the organization details from the iDEAL account below to generate these required files.</p>', 'pronamic_ideal' ),
				sprintf(
					__( 'A private key and certificate have been configured. The certificate must be uploaded to the payment provider dashboard to complete configuration.<br>%s <a href="#" id="pk-cert-fields-toggle">Show details...</a>', 'pronamic_ideal' ),
					get_submit_button( __( 'Download certificate', 'pronamic_ideal' ), 'secondary' , 'download_private_certificate', false )
				)
			),
		);

		// Organization
		$fields[] = array(
			'filter'      => FILTER_SANITIZE_STRING,
			'section'     => 'ideal',
			'methods'     => array( 'ideal-advanced-v3' ),
			'group'       => 'pk-cert',
			'meta_key'    => '_pronamic_gateway_organization',
			'title'       => __( 'Organization', 'pronamic_ideal' ),
			'type'        => 'text',
			'tooltip'     => __( 'Organization name, e.g. Pronamic', 'pronamic_ideal' ),
		);

		// Organization Unit
		$fields[] = array(
			'filter'      => FILTER_SANITIZE_STRING,
			'section'     => 'ideal',
			'methods'     => array( 'ideal-advanced-v3' ),
			'group'       => 'pk-cert',
			'meta_key'    => '_pronamic_gateway_organization_unit',
			'title'       => __( 'Organization Unit', 'pronamic_ideal' ),
			'type'        => 'text',
			'tooltip'     => __( 'Organization unit, e.g. Administration', 'pronamic_ideal' ),
		);

		// Locality
		$fields[] = array(
			'filter'      => FILTER_SANITIZE_STRING,
			'section'     => 'ideal',
			'methods'     => array( 'ideal-advanced-v3' ),
			'group'       => 'pk-cert',
			'meta_key'    => '_pronamic_gateway_locality',
			'title'       => __( 'City', 'pronamic_ideal' ),
			'type'        => 'text',
			'tooltip'     => __( 'City, e.g. Amsterdam', 'pronamic_ideal' ),
		);

		// State or Province
		$fields[] = array(
			'filter'      => FILTER_SANITIZE_STRING,
			'section'     => 'ideal',
			'methods'     => array( 'ideal-advanced-v3' ),
			'group'       => 'pk-cert',
			'meta_key'    => '_pronamic_gateway_state_or_province',
			'title'       => __( 'State / province', 'pronamic_ideal' ),
			'type'        => 'text',
			'tooltip'     => __( 'State or province, e.g. Friesland', 'pronamic_ideal' ),
		);

		// Country
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

		// Email Address
		$fields[] = array(
			'filter'      => FILTER_SANITIZE_STRING,
			'section'     => 'ideal',
			'methods'     => array( 'ideal-advanced-v3' ),
			'group'       => 'pk-cert',
			'meta_key'    => '_pronamic_gateway_email',
			'title'       => __( 'E-mail address', 'pronamic_ideal' ),
			'tooltip'     => sprintf(
				__( 'E-mail address, e.g. %s', 'pronamic_ideal' ),
				get_option( 'admin_email' )
			),
			'type'        => 'text',
		);

		// Number Days Valid
		$fields[] = array(
			'filter'      => FILTER_SANITIZE_NUMBER_INT,
			'section'     => 'ideal',
			'methods'     => array( 'ideal-advanced-v3' ),
			'group'       => 'pk-cert',
			'meta_key'    => '_pronamic_gateway_number_days_valid',
			'title'       => __( 'Number Days Valid', 'pronamic_ideal' ),
			'type'        => 'text',
			'default'     => 1825,
			'tooltip'     => __( 'Number of days the generated certificate will be valid for, e.g. 1825 days for the maximum duration of 5 years.', 'pronamic_ideal' ),
		);

		// Private Key Password
		$default_password = substr( str_shuffle( 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789' ) , 0 , 20 );

		$fields[] = array(
			'filter'      => FILTER_SANITIZE_STRING,
			'section'     => 'ideal',
			'methods'     => array( 'ideal-advanced-v3' ),
			'group'       => 'pk-cert',
			'meta_key'    => '_pronamic_gateway_ideal_private_key_password',
			'title'       => __( 'Private Key Password', 'pronamic_ideal' ),
			'type'        => 'text',
			'classes'     => array( 'regular-text', 'code' ),
			'default'     => $default_password,
			'tooltip'     => __( 'A random password which will be used for the generation of the private key and certificate.', 'pronamic_ideal' ),
		);

		// Private Key
		$fields[] = array(
			'filter'      => FILTER_SANITIZE_STRING,
			'section'     => 'ideal',
			'methods'     => array( 'ideal-advanced-v3' ),
			'group'       => 'pk-cert',
			'meta_key'    => '_pronamic_gateway_ideal_private_key',
			'title'       => __( 'Private Key', 'pronamic_ideal' ),
			'type'        => 'textarea',
			'callback'    => array( $this, 'field_private_key' ),
			'classes'     => array( 'code' ),
			'tooltip'     => __( 'The private key is used for secure communication with the payment provider. If left empty, the private key will be generated using the given private key password.', 'pronamic_ideal' ),
		);

		// Private Certificate
		$fields[] = array(
			'filter'      => FILTER_SANITIZE_STRING,
			'section'     => 'ideal',
			'methods'     => array( 'ideal-advanced-v3' ),
			'group'       => 'pk-cert',
			'meta_key'    => '_pronamic_gateway_ideal_private_certificate',
			'title'       => __( 'Private Certificate', 'pronamic_ideal' ),
			'type'        => 'textarea',
			'callback'    => array( $this, 'field_private_certificate' ),
			'classes'     => array( 'code' ),
			'tooltip'     => __( 'The certificate is used for secure communication with the payment provider. If left empty, the certificate will be generated using the private key and given organization details.', 'pronamic_ideal' ),
		);

		// Transaction feedback
		$fields[] = array(
			'section'     => 'ideal',
			'methods'     => array( 'ideal_advanced_v3' ),
			'title'       => __( 'Transaction feedback', 'pronamic_ideal' ),
			'type'        => 'description',
			'html'        => sprintf(
				'<span class="dashicons dashicons-yes pronamic-pay-yes"></span> %s',
				__( 'Payment status updates will be processed without any additional configuration.', 'pronamic_ideal' )
			),
		);

		// Return
		return $fields;
	}

	public function field_private_key( $field ) {
		$private_key_password = get_post_meta( get_the_ID(), '_pronamic_gateway_ideal_private_key_password', true );
		$number_days_valid    = get_post_meta( get_the_ID(), '_pronamic_gateway_number_days_valid', true );
		$filename = __( 'ideal', 'pronamic_ideal' );

		if ( ! empty( $private_key_password ) && ! empty( $number_days_valid ) ) {
			$command = sprintf(
				'openssl genrsa -aes128 -out %s.key -passout pass:%s 2048',
				$filename,
				$private_key_password
			);

			?>

			<p><?php esc_html_e( 'OpenSSL command', 'pronamic_ideal' ); ?></p>
			<input id="pronamic_ideal_openssl_command_key" name="pronamic_ideal_openssl_command_key" value="<?php echo esc_attr( $command ); ?>" type="text" class="large-text code" readonly="readonly" />

			<?php
		} else {
			printf(
				'<p><em>%s</em></p>',
				esc_html__( 'Leave empty and save the configuration to generate the private key or view the OpenSSL command.', 'pronamic_ideal' )
			);
		}
		?>

		<?php

		submit_button(
			__( 'Download', 'pronamic_ideal' ),
			'secondary' , 'download_private_key',
			false
		);

		?>

		<div class="input-file-wrapper button">
			<?php esc_html_e( 'Upload', 'pronamic_ideal' ); ?>
			<input type="file" name="_pronamic_gateway_ideal_private_key_file" />
		</div>

		<?php
	}

	public function field_private_certificate( $field ) {
		$certificate = get_post_meta( get_the_ID(), '_pronamic_gateway_ideal_private_certificate', true );

		$private_key_password = get_post_meta( get_the_ID(), '_pronamic_gateway_ideal_private_key_password', true );
		$number_days_valid    = get_post_meta( get_the_ID(), '_pronamic_gateway_number_days_valid', true );
		$filename = __( 'ideal', 'pronamic_ideal' );

		// @see http://www.openssl.org/docs/apps/req.html
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
			$command = trim( sprintf(
				'openssl req -x509 -sha256 -new -key %s.key -passin pass:%s -days %d -out %s.cer %s',
				$filename,
				$private_key_password,
				$number_days_valid,
				$filename,
				empty( $subj ) ? '' : sprintf( "-subj '%s'", $subj )
			) );

			?>

			<p><?php esc_html_e( 'OpenSSL command', 'pronamic_ideal' ); ?></p>
			<input id="pronamic_ideal_openssl_command_certificate" name="pronamic_ideal_openssl_command_certificate" value="<?php echo esc_attr( $command ); ?>" type="text" class="large-text code" readonly="readonly" />

			<?php
		} else {
			printf(
				'<p><em>%s</em></p>',
				esc_html__( 'Leave empty and save the configuration to generate the certificate or view the OpenSSL command.', 'pronamic_ideal' )
			);
		}

		if ( ! empty( $certificate ) ) {
			$fingerprint = Pronamic_WP_Pay_Gateways_IDealAdvancedV3_Security::get_sha_fingerprint( $certificate );
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

		submit_button(
			__( 'Download', 'pronamic_ideal' ),
			'secondary' , 'download_private_certificate',
			false
		);

		?>

		<div class="input-file-wrapper button">
			<?php esc_html_e( 'Upload', 'pronamic_ideal' ); ?>
			<input type="file" name="_pronamic_gateway_ideal_private_certificate_file" />
		</div>

		<?php
	}

	//////////////////////////////////////////////////

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

			echo get_post_meta( $post_id, '_pronamic_gateway_ideal_private_certificate', true ); //xss ok

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

			echo get_post_meta( $post_id, '_pronamic_gateway_ideal_private_key', true ); //xss ok

			exit;
		}
	}
}
