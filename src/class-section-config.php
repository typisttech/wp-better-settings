<?php
/**
 * WP Better Settings
 *
 * A simplified OOP implementation of the WP Settings API.
 *
 * @package   WP_Better_Settings
 * @author    Typist Tech <wp-better-settings@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   GPL-2.0+
 * @see       https://www.typist.tech/projects/wp-better-settings
 * @see       https://github.com/TypistTech/wp-better-settings
 */

namespace WP_Better_Settings;

use UnexpectedValueException;

/**
 * Class Section_Config.
 *
 * Config details for a settings field.
 *
 *
 * Details for a single section.
 *
 * Valid keys:
 *
 * 'title' (string)             =>  Title to display as the heading for the
 *                                  section.
 *
 * 'page' (string)              =>  The menu page on which to display this section.
 *                                  Should match $menu_slug in Menu_Page_Config.
 *
 * 'view' (string|View)         =>  View to use for rendering the section. Can be
 *                                  a path to a view file or an instance of a
 *                                  View object.
 *
 * 'fields' (Field_Config[])    =>  Array of Field_Config to attach to this
 *                                  section.
 *
 * @since 0.1.0
 */
class Section_Config extends Config {
	use View_Echo_Trait;

	/**
	 * Fields getter.
	 *
	 * @since 0.5.0
	 * @return Field_Config[]
	 * @throws UnexpectedValueException If fields is not Field_Config[].
	 */
	public function get_fields() : array {
		$this->validate_fields();

		return $this->get_key( 'fields' );
	}

	/**
	 * Check the fields.
	 *
	 * @since  0.5.0
	 * @access private
	 * @return void
	 * @throws UnexpectedValueException If fields is not Field_Config[].
	 */
	private function validate_fields() {
		$fields = $this->get_key( 'fields' );
		if ( ! is_array( $fields ) ) {
			$error_message = 'Fields in class ' . __CLASS__ . ' must be an array.';
			throw new UnexpectedValueException( $error_message );
		}

		array_walk( $fields, function ( $field ) {
			if ( ! $field instanceof Field_Config ) {
				$error_message = 'Field items in class ' . __CLASS__ . ' must be instances of Field_Config.';
				throw new UnexpectedValueException( $error_message );
			}
		} );
	}

	/**
	 * Default config of Section_Config.
	 *
	 * @since 0.1.0
	 * @return array
	 */
	protected function default_config() : array {
		return [
			'view'     => View_Factory::build( 'section-description' ),
			'callback' => [ $this, 'echo_view' ],
		];
	}
}
