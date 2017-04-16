<?php
/**
 * WP Better Settings
 *
 * A simplified OOP implementation of the WP Settings API.
 *
 * @package TypistTech\WPBetterSettings
 *
 * @author Typist Tech <wp-better-settings@typist.tech>
 * @copyright 2017 Typist Tech
 * @license GPL-2.0+
 *
 * @see https://www.typist.tech/projects/wp-better-settings
 * @see https://github.com/TypistTech/wp-better-settings
 */

declare(strict_types=1);

namespace TypistTech\WPBetterSettings\Fields;

/**
 * Abstract class AbstractInput
 */
abstract class AbstractInput extends AbstractField
{
    const TYPE = self::TYPE;

    /**
     * Type getter.
     *
     * @return string
     */
    public function getType(): string
    {
        return static::TYPE;
    }
}
