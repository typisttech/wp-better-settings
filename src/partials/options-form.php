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

settings_errors();

do_action( $snakecased_menu_slug . '_before_option_form' );

echo '<form action="options.php" method="post">';
settings_fields( $context->option_group );

do_action( $snakecased_menu_slug . '_before_settings_sections' );

do_settings_sections( $context->menu_slug );

do_action( $snakecased_menu_slug . '_before_submit_button' );

submit_button();

do_action( $snakecased_menu_slug . '_after_submit_button' );

echo '</form>';

do_action( $snakecased_menu_slug . '_after_option_form' );
