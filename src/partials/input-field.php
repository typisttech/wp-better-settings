<?php
/**
 * WP Better Settings
 *
 * A simplified OOP implementation of the WP Settings API.
 *
 * @package   WP_Better_Settings
 * @author    Typist Tech <wp-better-settings@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   GPL-2.0+
 * @see       https://www.typist.tech/projects/wp-better-settings
 * @see       https://github.com/TypistTech/wp-better-settings
 */

namespace WP_Better_Settings;

/* @var \ArrayObject $context Context passed through from Settings class. */

echo '<input class="regular-text" ';
echo 'type="' . esc_attr( $type ?? 'text' ) . '" ';
echo 'value="' . esc_attr( $context->value ) . '" ';
include __DIR__ . '/common-attributes.php';
echo ' >';

include __DIR__ . '/description-paragraph.php';
