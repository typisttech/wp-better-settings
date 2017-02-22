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
 * Details for a single section.
 *
 * Valid keys:
 *
 * 'title' (string)            =>  Title to display as the heading for the
 *                              section.
 *
 * 'page' (string)            =>  The menu page on which to display this section.
 *                              Should match $menu_slug in Menu_Page_Config.
 *
 * 'view' (string|View)        =>  View to use for rendering the section. Can be
 *                              a path to a view file or an instance of a
 *                              View object.
 *
 * 'fields' (Field_Config[])    =>    Array of Field_Config to attach to this
 *                              section.
 */
class Section_Config extends Config {

	/**
	 * Default config of Section_Config
	 *
	 * @since 0.1.0
	 *
	 * @return array
	 * @throws \InvalidArgumentException If the partial is not supported.
	 */
	protected function default_config() : array {
		return [
			'view'     => ViewFactory::build( 'section-description' ),
			'callback' => function () {
				if ( is_string( $this->view ) ) {
					$this->view = new View( $this->view );
				}
				$this->view->echo_kses( $this );
			},
		];
	}
}
