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

use ArrayObject;

/**
 * Class Config.
 *
 * Config details for a settings field.
 *
 * @since 0.1.0
 */
class Config extends ArrayObject
{
    /**
     * Config constructor.
     *
     * @since 0.1.0
     *
     * @param array $config Custom config array.
     */
    public function __construct(array $config = [])
    {
        $config = array_replace_recursive($this->defaultConfig(), $config);

        // Make sure the config entries can be accessed as properties.
        parent::__construct(
            array_filter($config),
            ArrayObject::ARRAY_AS_PROPS
        );
    }

    /**
     * Default config.
     *
     * To be overridden by subclass.
     *
     * @since 0.1.0
     * @return array
     */
    protected function defaultConfig() : array
    {
        return [];
    }

    /**
     * Get the value of a specific key.
     *
     * @since 0.1.0
     *
     * @param string $key The key to get the value for.
     *
     * @return mixed Value of the requested key.
     *               Or, null if undefined.
     */
    public function getKey(string $key)
    {
        return $this[ $key ] ?? null;
    }

    /**
     * Get an array with all the keys.
     *
     * @since 0.1.0
     * @return array Array of config keys.
     */
    public function getKeys() : array
    {
        return array_keys((array) $this);
    }

    /**
     * Check whether the Config has a specific key.
     *
     * @since 0.1.0
     *
     * @param string $key The key to check the existence for.
     *
     * @return bool Whether the specified key exists.
     */
    public function hasKey(string $key) : bool
    {
        return array_key_exists($key, (array) $this);
    }
}
