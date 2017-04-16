<?php
/**
 * WP Better Settings
 *
 * A simplified OOP implementation of the WP Settings API.
 *
 * @package   TypistTech\WPBetterSettings
 *
 * @author    Typist Tech <wp-better-settings@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   GPL-2.0+
 *
 * @see       https://www.typist.tech/projects/wp-better-settings
 * @see       https://github.com/TypistTech/wp-better-settings
 */

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

/**
 * Final class OptionStore.
 */
class OptionStore implements OptionStoreInterface
{
    /**
     * Get an option value from constant or database.
     *
     * Wrapper around the WordPress function `get_option`.
     * Can be overridden by constant `OPTION_NAME`.
     *
     * @param string $optionName Name of option to retrieve.
     *                           Expected to not be SQL-escaped.
     *
     * @return mixed
     */
    public function get(string $optionName)
    {
        $constantName = $this->constantNameFor($optionName);
        if (defined($constantName)) {
            $value = constant($constantName);
        } else {
            $value = $this->getFromDatabase($optionName);
        }

        $filterTag = $this->filterTagFor($optionName);

        return apply_filters($filterTag, $value);
    }

    /**
     * Normalize option name and key to SCREAMING_SNAKE_CASE constant name.
     *
     * @param string $optionName Name of option to retrieve.
     *                           Expected to not be SQL-escaped.
     *
     * @return string
     */
    private function constantNameFor(string $optionName): string
    {
        return strtoupper($optionName);
    }

    /**
     * Get option from database.
     *
     * @param string $optionName Name of option to retrieve.
     *                           Expected to not be SQL-escaped.
     *
     * @return mixed
     */
    private function getFromDatabase(string $optionName)
    {
        return get_option($optionName);
    }

    /**
     * Normalize option name and key to snake_case filter tag.
     *
     * @param string $optionName Name of option to retrieve.
     *                           Expected to not be SQL-escaped.
     *
     * @return string
     */
    private function filterTagFor(string $optionName): string
    {
        return strtolower($optionName);
    }
}
