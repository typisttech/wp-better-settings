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

use UnexpectedValueException;

/**
 * Config details for a settings field.
 *
 * @since 0.1.0
 *
 * Details for a single set of settings.
 *
 * Valid keys:
 *
 * 'option_group' (string)      =>  A settings group name.
 *                                  Should correspond to a whitelisted option
 *                                  key name.
 *
 * 'option_name' (string)       =>    The name of an option to sanitize and save.
 *
 * 'sections' (Section_Config[])    =>  Array of Section_Config to add to the settings page.
 */
class Setting_Config extends Config {

	/**
	 * Default config of Setting_Config.
	 *
	 * @since 0.1.0
	 *
	 * @return array
	 */
	protected function default_config() : array {
		return [
			'view'     => View_Factory::build( 'section-description' ),
			'function' => function () {
				if ( is_string( $this->view ) ) {
					$this->view = new View( $this->view );
				}
				$this->view->echo_kses( $this );
			},
			'args'     => [
				'sanitize_callback' => function ( array $input ) {
					$input_keys = array_keys( $input );
					$fields     = $this->get_fields_by( $input_keys );

					return Sanitizer::sanitize_settings( $fields, $input );
				},
			],
		];
	}

	/**
	 * Get fields by ids.
	 *
	 * @since  0.5.0
	 * @access private
	 *
	 * @param array $field_ids IDs of the fields to return.
	 *
	 * @return Field_Config[]
	 * @throws \UnexpectedValueException If section.fields is not Field_Config[].
	 */
	private function get_fields_by( array $field_ids ) : array {
		$field_ids  = array_filter( $field_ids );
		$all_fields = $this->get_fields();

		return array_filter( $all_fields, function ( Field_Config $field ) use ( $field_ids ) {
			$id = $field->get_key( 'id' );

			return in_array( $id, $field_ids, true );
		} );
	}

	/**
	 * Get all fields.
	 *
	 * @since 0.1.0
	 *
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
		$this->check_sections();

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
	private function check_sections() {
		$sections = $this->get_key( 'sections' );
		if ( ! is_array( $sections ) ) {
			throw new UnexpectedValueException( 'Sections in class ' . __CLASS__ . ' must be an array.' );
		}

		array_walk( $sections, function ( $section ) {
			if ( ! $section instanceof Section_Config ) {
				throw new UnexpectedValueException( 'Section items in class ' . __CLASS__ . ' must be instances of Section_Config.' );
			}
		} );
	}
}
