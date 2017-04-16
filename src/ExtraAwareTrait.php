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
 * Trait ExtraAwareTrait
 */
trait ExtraAwareTrait
{
    /**
     * Additional information that is passed to the template partial through view object.
     *
     * @var array
     */
    protected $extra = [];

    /**
     * Extra getter.
     *
     * @return array
     */
    public function getExtra(): array
    {
        return $this->extra;
    }

    /**
     * Extra element setter.
     *
     * @param string $key   Key of the extra array.
     * @param mixed  $value Value of $extra[$key].
     *
     * @return void
     */
    public function setExtraElement(string $key, $value)
    {
        $this->extra[ $key ] = $value;
    }
}
