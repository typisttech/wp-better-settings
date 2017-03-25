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
 * Interface ViewInterface
 *
 * Accepts a context and echo its content on request.
 *
 * @since 0.2.0
 */
interface ViewInterface
{
    /**
     * Echo a given view safely.
     *
     * @since 0.2.0
     *
     * @param mixed $context Context ArrayObject for which to render the view.
     *
     * @return void
     */
    public function echoKses($context);
}
