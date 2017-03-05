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

echo '<textarea class="regular-text" ';
if ( absint( $context->rows ) > 0 ) {
	echo 'rows="' . absint( $context->rows ) . '" ';
}
include __DIR__ . '/common-attributes.php';
echo ' >';

echo esc_textarea( $context->value );

echo '</textarea>';

include __DIR__ . '/description-paragraph.php';
