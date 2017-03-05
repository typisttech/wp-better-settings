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

/* @var \ArrayObject $context Context passed through from Menu_Pages class. */

$snakecased_menu_slug = str_replace( '-', '_', $context->menu_slug );

do_action( $snakecased_menu_slug . '_before_page_title' );

echo '<h1>' . esc_html( $context->page_title ) . '</h1>';

do_action( $snakecased_menu_slug . '_after_page_title' );

include __DIR__ . '/options-form.php';
