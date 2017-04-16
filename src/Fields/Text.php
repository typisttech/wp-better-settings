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

use TypistTech\WPBetterSettings\View;
use TypistTech\WPBetterSettings\ViewFactory;

/**
 * Final class Text
 */
final class Text extends AbstractInput
{
    const TYPE = 'text';

    /**
     * {@inheritdoc}
     */
    protected function getDefaultView(): View
    {
        return ViewFactory::build('fields/input');
    }
}
