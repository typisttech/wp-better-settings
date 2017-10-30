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

use Closure;

interface FieldInterface
{
    /**
     * String for use in the 'id' attribute of tags.
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Title of the field.
     *
     * @return string
     */
    public function getTitle(): string;

    /**
     * Closure that fills the field with the desired inputs as part of the larger form. The closure should echo its
     * output.
     *
     * @return Closure
     */
    public function getRenderClosure(): Closure;

    /**
     * Additional arguments that are passed to the render closure.
     *
     * @return array
     */
    public function getAdditionalRenderArguments(): array;

    /**
     * Data used to describe the setting when registered.
     *
     * @return array
     */
    public function getAdditionalSettingArguments(): array;
}
