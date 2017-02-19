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
 * Class OptionsStore.
 *
 * This is a very basic adapter for the WordPress get_option()
 * function that can be configured to supply consistent default
 * values for particular options.
 *
 * @since 0.1.0
 */
class OptionsStore implements OptionsStoreInterface {
	/**
	 * Get an option value, falling back to default values if configured.
	 *
	 * @since 0.1.0
	 *
	 * @param string $option_name Name of option to retrieve.
	 *                            Expected to not be SQL-escaped.
	 * @param string $key         Array key of the option element.
	 *                            Also, the field ID.
	 *
	 * @return mixed $option_name[ $key ] or false if all not set.
	 */
	public function get( string $option_name, string $key ) {
		$option = get_option( $option_name, array() );

		// TODO: Add filters and hooks.
		return $option[ $key ] ?? false;
	}
}
