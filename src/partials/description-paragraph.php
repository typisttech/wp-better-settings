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

if ( ! empty( $context->desc ) ) {
	echo '<p class="description" ';
	echo 'id="' . esc_attr( $context->id . '-description' ) . '">';
	echo wp_kses_post( $context->desc );
	echo '</p>';
}
