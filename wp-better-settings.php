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
 *
 * Plugin Name: WP Better Settings
 * Plugin URI:  https://github.com/TypistTech/wp-better-settings
 * Description: Example Plugin for WP Better Settings
 * Version:     0.3.0
 * Author:      Tang Rufus
 * Author URI:  https://www.typist.tech/
 * Text Domain: wp-better-settings
 * Domain Path: src/languages
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

namespace WPBS;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';
require_once plugin_dir_path( __FILE__ ) . 'class-plugin.php';

// Initialize the plugin.
( new Plugin() )->init();
