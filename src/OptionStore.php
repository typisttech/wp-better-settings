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
 * Class OptionStore.
 *
 * This is a very basic adapter for the WordPress get_option()
 * function that can be configured to supply consistent default
 * values for particular options.
 *
 * @since 0.5.0
 */
class OptionStore implements OptionStoreInterface
{
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
    public function get(string $option_name, string $key)
    {
        $option = get_option($option_name, []);

        if (! is_array($option)) {
            return $option;
        }

        // TODO: Add filters and hooks.
        return $option[ $key ] ?? false;
    }
}
