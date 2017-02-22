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
	 * Get field config by id.
	 *
	 * @since 0.1.0
	 *
	 * @param string $field_id ID of the field.
	 *
	 * @return mixed
	 */
	public function get_field( string $field_id ) {
		$fields      = $this->get_fields();
		$field_index = array_search( $field_id, array_column( $fields, 'id' ), true );

		if ( false === $field_index ) {
			return null;
		}

		return $fields[ $field_index ];
	}

	/**
	 * Get all fields.
	 *
	 * @since 0.1.0
	 *
	 * @return array
	 */
	public function get_fields() : array {
		if ( ! is_array( $this->get_key( 'sections' ) ) ) {
			return [];
		}

		$pluck = array_column( $this->sections, 'fields' );

		// Flatten $pluck array.
		$fields = [];
		array_walk_recursive( $pluck, function ( $a ) use ( &$fields ) {
			$fields[] = $a;
		} );

		return $fields;
	}

	/**
	 * Array of default options.
	 *
	 * @since 0.1.0
	 *
	 * @return array
	 */
	public function default_option() : array {
		$fields = $this->get_fields();

		return array_column( $fields, 'default', 'id' );
	}

	/**
	 * Default config of Setting_Config
	 *
	 * @since 0.1.0
	 *
	 * @return array
	 * @throws \InvalidArgumentException If the partial is not supported.
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
					return Sanitizer::sanitize_settings( $this, $input );
				},
			],
		];
	}
}
