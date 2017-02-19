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
 * Class FieldConfig
 *
 * Config details for a settings field.
 *
 * @since 0.1.0
 *
 * Valid keys:
 *
 * 'id' (string)                    => ID of this field. Should be unique for each page
 *
 * 'title' (string)                 => Title to display as the heading for
 *                                     the section.
 *
 * 'view' (string|ViewInterface)    => View to use for rendering the
 *                                     section. Can be a path to a view file
 *                                     or an instance of a View object.
 */
class FieldConfig extends Config {
	/**
	 * Default config of FieldConfig
	 *
	 * @since 0.1.0
	 *
	 * @return array
	 * @throws \InvalidArgumentException If the partial is not supported.
	 */
	protected function default_config() : array {
		return [
			'callback' => function () {
				if ( is_string( $this->view ) ) {
					$this->view = new View( $this->view );
				}
				$this->view->echo_kses( $this );
			},
		];
	}
}
