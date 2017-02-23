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
 * Class Section_Config.
 *
 * Config details for a settings field.
 *
 * @since 0.1.0
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
 */
class Section_Config extends Config {

	/**
	 * Fields getter
	 *
	 * @since 0.5.0
	 * @return Field_Config[]
	 * @throws UnexpectedValueException If fields is not Field_Config[].
	 */
	public function get_fields() : array {
		$this->check_fields();

		return $this->get_key( 'fields' );
	}

	/**
	 * Check the fields
	 *
	 * @since  0.5.0
	 * @access private
	 * @return void
	 * @throws UnexpectedValueException If fields is not Field_Config[].
	 */
	private function check_fields() {
		$fields = $this->get_key( 'fields' );
		if ( ! is_array( $fields ) ) {
			throw new UnexpectedValueException( 'Fields in class ' . __CLASS__ . ' must be an array.' );
		}

		array_walk( $fields, function ( $field ) {
			if ( ! $field instanceof Field_Config ) {
				throw new UnexpectedValueException( 'Field items in class ' . __CLASS__ . ' must be instances of Field_Config.' );
			}
		} );
	}

	/**
	 * Default config of Section_Config
	 *
	 * @since 0.1.0
	 *
	 * @return array
	 */
	protected function default_config() : array {
		return [
			'view'     => View_Factory::build( 'section-description' ),
			'callback' => function () {
				if ( is_string( $this->view ) ) {
					$this->view = new View( $this->view );
				}
				$this->view->echo_kses( $this );
			},
		];
	}
}
