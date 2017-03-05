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

namespace WP_Better_Settings\WPBetterSettings;

/* @var \ArrayObject $context Context passed through from Menu_Pages class. */

settings_errors();

do_action( str_replace( '-', '_', $context->menu_slug ) . '_before_option_form' );

echo '<form action="options.php" method="post">';
settings_fields( $context->option_group );

do_action( str_replace( '-', '_', $context->menu_slug ) . '_before_settings_sections' );

do_settings_sections( $context->menu_slug );

do_action( str_replace( '-', '_', $context->menu_slug ) . '_before_submit_button' );

submit_button();

do_action( str_replace( '-', '_', $context->menu_slug ) . '_after_submit_button' );

echo '</form>';

do_action( str_replace( '-', '_', $context->menu_slug ) . '_after_option_form' );
