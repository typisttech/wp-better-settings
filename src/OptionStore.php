<?php
/**
 * WP Better Settings
 *
 * A simplified OOP implementation of the WP Settings API.
 *
 * @package   TypistTech\WPBetterSettings
 * @author    Typist Tech <wp-better-settings@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   GPL-2.0+
 * @see       https://www.typist.tech/projects/wp-better-settings
 * @see       https://github.com/TypistTech/wp-better-settings
 */

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

/**
 * Class OptionStore.
 *
 * This is a very basic adapter for the WordPress get_option()
 * function that can be configured to supply consistent default
 * values for particular options.
 */
class OptionStore implements OptionStoreInterface
{
    /**
     * Get an option value from constant or database.
     *
     * Wrapper around the WordPress function `get_option`.
     * Can be overridden by constant `OPTION_NAME_KEY`.
     *
     * @param string $optionName  Name of option to retrieve.
     *                            Expected to not be SQL-escaped.
     * @param string $key         Optional. Array key of the option element.
     *                            Also, the field ID.
     *
     * @return mixed
     */
    public function get(string $optionName, string $key = null)
    {
        $constantName = $this->constantNameFor($optionName, $key);
        if (defined($constantName)) {
            $value = constant($constantName);
        } else {
            $value = $this->getFromDatabase($optionName, $key);
        }

        $filterTag = $this->filterTagFor($optionName, $key);

        return apply_filters($filterTag, $value);
    }

    /**
     * Normalize option name and key to SCREAMING_SNAKE_CASE constant name.
     *
     * @param string $optionName  Name of option to retrieve.
     *                            Expected to not be SQL-escaped.
     * @param string $key         Optional. Array key of the option element.
     *                            Also, the field ID.
     *
     * @return string
     */
    private function constantNameFor(string $optionName, string $key = null): string
    {
        $name = empty($key) ? $optionName : $optionName . '_' . $key;

        return strtoupper($name);
    }

    /**
     * Get option from database.
     *
     * @param string $optionName  Name of option to retrieve.
     *                            Expected to not be SQL-escaped.
     * @param string $key         Optional. Array key of the option element.
     *                            Also, the field ID.
     *
     * @return mixed
     */
    private function getFromDatabase(string $optionName, string $key = null)
    {
        $option = get_option($optionName);

        if (! empty($key) && is_array($option)) {
            return $option[ $key ] ?? false;
        }

        return $option;
    }

    /**
     * Normalize option name and key to snake_case filter tag.
     *
     * @param string $optionName  Name of option to retrieve.
     *                            Expected to not be SQL-escaped.
     * @param string $key         Optional. Array key of the option element.
     *                            Also, the field ID.
     *
     * @return string
     */
    private function filterTagFor(string $optionName, string $key = null): string
    {
        $name = empty($key) ? $optionName : $optionName . '_' . $key;

        return strtolower($name);
    }
}
