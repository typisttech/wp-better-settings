<?php
/**
 * WP Better Settings
 *
 * A simplified OOP implementation of the WP Settings API.
 *
 * @package   WPBS\WP_Better_Settings
 * @author    Typist Tech <wp-better-settings@typist.tech>
 * @license   GPL-2.0+
 * @link      https://www.typist.tech/
 * @copyright 2017 Typist Tech
 */

namespace WP_Better_Settings\WPBetterSettings\partials;

/* @var \ArrayObject $context Context passed through from Settings class. */

echo '<input class="regular-text" ';
echo 'type="' . esc_attr( $type ?? 'text' ) . '" ';
echo 'value="' . esc_attr( $context->value ) . '" ';
include __DIR__ . '/common-attributes.php';
echo ' >';

include __DIR__ . '/description-paragraph.php';