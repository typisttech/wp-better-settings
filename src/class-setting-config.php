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

namespace WP_Better_Settings;

use UnexpectedValueException;

/**
 * Config details for a settings field.
 *
 * Details for a single set of settings.
 *
 * Valid keys:
 *
 * 'option_group' (string)          =>  A settings group name.
 *                                      Should correspond to a whitelisted option
 *                                      key name.
 *
 * 'option_name' (string)           =>  The name of an option to sanitize and save.
 *
 * 'sections' (Section_Config[])    =>  Array of Section_Config to add to the settings page.
 *
 * @since 0.1.0
 */
class Setting_Config extends Config {

	use View_Echo_Trait;

	/**
	 * Sanitize settings fields.
	 *
	 * @since 0.5.0
	 *
	 * @param array $input The value entered in the field.
	 *
	 * @return array The sanitized values.
	 * @throws \UnexpectedValueException If fields is not Field_Config[].
	 */
	public function call_field_sanitize_fun( array $input ) {
		$field_ids     = array_keys( $input );
		$field_ids     = array_filter( $field_ids );
		$field_configs = $this->get_fields_by( $field_ids );

		foreach ( $field_configs as $field_config ) {
			$sanitize_callback = $field_config->get_key( 'sanitize_callback' );
			if ( ! is_callable( $sanitize_callback ) ) {
				continue;
			}

			$id           = $field_config->get_key( 'id' );
			$input[ $id ] = $sanitize_callback( $input[ $id ], $id );
		}

		// Unset empty elements.
		return array_filter( $input );
	}

	/**
	 * Get fields by ids.
	 *
	 * @since  0.5.0
	 * @access private
	 *
	 * @param array $ids IDs of the fields to return.
	 *
	 * @return Field_Config[]
	 * @throws \UnexpectedValueException If section.fields is not Field_Config[].
	 */
	private function get_fields_by( array $ids ) : array {
		$ids        = array_filter( $ids );
		$all_fields = $this->get_fields();

		return array_filter( $all_fields, function ( Field_Config $field ) use ( $ids ) {
			$id = $field->get_key( 'id' );

			return in_array( $id, $ids, true );
		} );
	}

	/**
	 * Get all fields.
	 *
	 * @since 0.1.0
	 * @return Field_Config[]
	 * @throws \UnexpectedValueException If sections.fields is not Field_Config[].
	 */
	public function get_fields() : array {
		$sections = $this->get_sections();

		$pluck = array_map(
			function ( Section_Config $section ) {
				return $section->get_fields();
			},
			$sections
		);

		return call_user_func_array( 'array_merge', $pluck );
	}

	/**
	 * Sections getter.
	 *
	 * @since 0.5.0
	 * @return Section_Config[]
	 * @throws \UnexpectedValueException If sections is not Section_Config[].
	 */
	public function get_sections() : array {
		$this->validate_sections();

		return $this->get_key( 'sections' );
	}

	/**
	 * Check the sections.
	 *
	 * @since  0.5.0
	 * @access private
	 * @return void
	 * @throws UnexpectedValueException If fields is not Field_Config[].
	 */
	private function validate_sections() {
		$sections = $this->get_key( 'sections' );
		if ( ! is_array( $sections ) ) {
			$error_message = 'Sections in class ' . __CLASS__ . ' must be an array.';
			throw new UnexpectedValueException( $error_message );
		}

		array_walk( $sections, function ( $section ) {
			if ( ! $section instanceof Section_Config ) {
				$error_message = 'Section items in class ' . __CLASS__ . ' must be instances of Section_Config.';
				throw new UnexpectedValueException( $error_message );
			}
		} );
	}

	/**
	 * Default config of Setting_Config.
	 *
	 * @since 0.1.0
	 * @return array
	 */
	protected function default_config() : array {
		return [
			'view'     => View_Factory::build( 'section-description' ),
			'function' => [ $this, 'echo_view' ],
			'args'     => [
				'sanitize_callback' => [ $this, 'call_field_sanitize_fun' ],
			],
		];
	}
}
