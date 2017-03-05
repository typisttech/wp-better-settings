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

echo '<h1>' . esc_html( $context->page_title ) . '</h1>';

include __DIR__ . '/options-form.php';