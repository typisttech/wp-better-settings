<?php
/**
 * WP Better Settings
 *
 * A simplified OOP implementation of the WP Settings API.
 *
 * @package TypistTech\WPBetterSettings
 * @author Typist Tech <wp-better-settings@typist.tech>
 * @copyright 2017 Typist Tech
 * @license GPL-2.0+
 * @see https://www.typist.tech/projects/wp-better-settings
 * @see https://github.com/TypistTech/wp-better-settings
 */

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

/**
 * Interface OptionStoreInterface.
 *
 * This is a very basic adapter for the WordPress get_option()
 * function that can be configured to supply consistent default
 * values for particular options.
 *
 * @since 0.5.0
 */
interface OptionStoreInterface
{
    /**
     * Get an option value.
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
    public function get(string $option_name, string $key);
}
