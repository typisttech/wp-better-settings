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

/* @var \ArrayObject $context Context passed through from Settings class. */

$name = sprintf(
    '%s[%s]',
    esc_html($context->option_name),
    esc_html($context->id)
);

echo ' name="' . esc_attr($name) . '" ';
echo 'id="' . esc_attr($context->id) . '" ';
if (! empty($context->desc)) {
    echo 'aria-describedby="' . esc_attr(esc_attr($context->id . '-description')) . '" ';
}
disabled($context->disabled ?? false);
echo ' ';
