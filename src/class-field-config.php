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

/**
 * Class Field_Config.
 *
 * Config details for a settings field.
 *
 * Valid keys:
 *
 * 'id' (string)                    =>  ID of this field. Should be unique for each page
 *
 * 'title' (string)                 =>  Title to display as the heading for
 *                                      the section.
 *
 * 'view' (string|View_Interface)   =>  View to use for rendering the
 *                                      section. Can be a path to a view file
 *                                      or an instance of a View object.
 *
 * @since 0.1.0
 */
class Field_Config extends Config {

	use View_Echo_Trait;

	/**
	 * Default config of Field_Config.
	 *
	 * @since 0.1.0
	 * @return array
	 */
	protected function default_config() : array {
		return [
			'callback'          => [ $this, 'echo_view' ],
			'sanitize_callback' => 'sanitize_text_field',
		];
	}
}