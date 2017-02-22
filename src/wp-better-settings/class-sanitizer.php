<?php
/**
 * WP Better Settings
 *
 * A simplified OOP implementation of the WP Settings API.
 *
 * @package   WPBS\WP_Better_Settings
 * @author    Typist Tech <wp-better-settings@typist.tech>
 * @license   GPL-2.0+
 * @link      https://www.typist.tech/
 * @copyright 2017 Typist Tech
 */

namespace WPBS\WP_Better_Settings;

/**
 * Class Sanitizer
 *
 * @since 0.1.0
 */
class Sanitizer {
	/**
	 * Sanitize settings fields.
	 *
	 * @since 0.1.0
	 *
	 * @param Setting_Config $setting_config Config object of plugin settings.
	 * @param array          $input          The value entered in the field.
	 *
	 * @return array The sanitized value.
	 */
	public static function sanitize_settings( Setting_Config $setting_config, array $input ) {
		// Unset empty elements.
		$input = array_filter( $input );

		// TODO: This loop needs refactor.
		foreach ( $input as $id => $value ) {
			$field = $setting_config->get_field( $id );

			if ( empty( $field ) ) {
				continue;
			}

			if ( ! is_callable( $field->sanitize_callback ) ) {
				continue;
			}

			$input[ $id ] = call_user_func( $field->sanitize_callback, $value, $id );
		}

		// Unset empty elements.
		$input = array_filter( $input );

		return $input;
	}


	/**
	 * Sanitize checkbox
	 *
	 * Sanitize any input other than '1', 1 or boolean true to empty string.
	 *
	 * @since 0.4.0
	 *
	 * @param string $input User submitted value.
	 *
	 * @return string Empty string OR '1'
	 */
	public static function sanitize_checkbox( string $input ) : string {
		$sanitized_input = sanitize_text_field( $input );
		if ( '1' !== $sanitized_input ) {
			$sanitized_input = '';
		}

		return $sanitized_input;
	}

	/**
	 * Sanitize email
	 *
	 * Strips out all characters that are not allowable in an email address.
	 * Add settings error if email is not valid.
	 *
	 * @since 0.1.0
	 *
	 * @param string $input    Input email.
	 * @param string $field_id ID of the settings field.
	 *
	 * @return string           Valid email address OR empty string.
	 */
	public static function sanitize_email( string $input, string $field_id ) : string {

		$sanitized_input = sanitize_email( $input );
		if ( ! is_email( $sanitized_input ) ) {
			$error = __( 'The email address entered did not appear to be a valid email address. Please enter a valid email address.' );
			add_settings_error( $field_id, "invalid_$field_id", $error );
		}

		return $sanitized_input;
	}
}
