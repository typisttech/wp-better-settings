<?php
/**
 * WP Better Settings
 *
 * A simplified OOP implementation of the WP Settings API.
 *
 * @package   TypistTech\WPBetterSettings
 *
 * @author    Typist Tech <wp-better-settings@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   GPL-2.0+
 *
 * @see       https://www.typist.tech/projects/wp-better-settings
 * @see       https://github.com/TypistTech/wp-better-settings
 */

/**
 * Plugin Name: WP Better Settings
 * Plugin URI:  https://github.com/TypistTech/wp-better-settings
 * Description: Example Plugin for WP Better Settings
 * Version:     0.11.0
 * Author:      Tang Rufus
 * Author URI:  https://www.typist.tech/
 * Text Domain: wp-better-settings
 * Domain Path: src/languages
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';
require_once plugin_dir_path(__FILE__) . 'class-plugin.php';

// Initialize the plugin.
(new Plugin())->init();

/**
 * You can use hooks like so.
 */
function add_hooked_paragraph()
{
    echo '<p>This paragraph is add via <code>';
    echo esc_attr(str_replace('wpbs_simple', '{$snakecased_menu_slug}', current_filter()));
    echo '</code> hook </p>';
}

add_action('wpbs_simple_before_page_title', 'TypistTech\WPBetterSettings\add_hooked_paragraph');
add_action('wpbs_simple_after_page_title', 'TypistTech\WPBetterSettings\add_hooked_paragraph');
add_action('wpbs_simple_before_nav_tabs', 'TypistTech\WPBetterSettings\add_hooked_paragraph');
add_action('wpbs_simple_after_nav_tabs', 'TypistTech\WPBetterSettings\add_hooked_paragraph');
add_action('wpbs_simple_before_option_form', 'TypistTech\WPBetterSettings\add_hooked_paragraph');
add_action('wpbs_simple_before_settings_sections', 'TypistTech\WPBetterSettings\add_hooked_paragraph');
add_action('wpbs_simple_before_section_content', 'TypistTech\WPBetterSettings\add_hooked_paragraph');
add_action('wpbs_simple_after_section_content', 'TypistTech\WPBetterSettings\add_hooked_paragraph');
add_action('wpbs_simple_after_settings_sections', 'TypistTech\WPBetterSettings\add_hooked_paragraph');
add_action('wpbs_simple_before_submit_button', 'TypistTech\WPBetterSettings\add_hooked_paragraph');
add_action('wpbs_simple_after_submit_button', 'TypistTech\WPBetterSettings\add_hooked_paragraph');
add_action('wpbs_simple_after_option_form', 'TypistTech\WPBetterSettings\add_hooked_paragraph');
