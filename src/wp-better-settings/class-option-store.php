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
 * Class Option_Store.
 *
 * This is a very basic adapter for the WordPress get_option()
 * function that can be configured to supply consistent default
 * values for particular options.
 *
 * @since 0.5.0
 */
class Option_Store implements Option_Store_Interface {

	/**
	 * Get an option value from database.
	 *
	 * Wrapper around the WordPress function `get_option`.
	 *
	 * @since 0.5.0
	 *
	 * @param string $option_name Name of option to retrieve.
	 *                            Expected to not be SQL-escaped.
	 * @param string $key         Array key of the option element.
	 *                            Also, the field ID.
	 *
	 * @return mixed
	 */
	public function get( string $option_name, string $key ) {
		$option = get_option( $option_name, [] );

		if ( ! is_array( $option ) ) {
			return $option;
		}

		// TODO: Add filters and hooks.
		return $option[ $key ] ?? false;
	}
}
