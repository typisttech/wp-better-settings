<?php
/**
 * WP Better Settings
 *
 * A simplified OOP implementation of the WP Settings API
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
 *                              Should match $menu_slug in MenuPageConfig.
 *
 * 'view' (string|View)        =>  View to use for rendering the section. Can be
 *                              a path to a view file or an instance of a
 *                              View object.
 *
 * 'fields' (FieldConfig[])    =>    Array of FieldConfig to attach to this
 *                              section.
 */
class SectionConfig extends Config {

	/**
	 * Add a field
	 *
	 * @since 0.1.0
	 *
	 * @param FieldConfig $field Field config to be added.
	 *
	 * @return SectionConfig $this
	 */
	public function add_field( FieldConfig $field ) {
		$this[ $field->id ] = $field;

		return $this;
	}

	/**
	 * Default config of SectionConfig
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
