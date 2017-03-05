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

echo '<fieldset><legend class="screen-reader-text">';
echo '<span>' . esc_html( $context->title ) . '</span></legend>';

echo '<label for="' . esc_html( $context->id ) . '">';

echo '<input type="checkbox" value="1" ';
include __DIR__ . '/common-attributes.php';
checked( $context->value );
echo ' >';

echo wp_kses_post( $context->label );
echo '</label>';

include __DIR__ . '/description-paragraph.php';

echo '</fieldset>';