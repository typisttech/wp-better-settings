<?php
/**
 * WP Better Settings
 *
 * A simplified OOP implementation of the WP Settings API.
 *
 * @package TypistTech\WPBetterSettings
 * @author Typist Tech <wp-better-settings@typist.tech>
 * @copyright 2017 Typist Tech
 * @license GPL-2.0+
 * @see https://www.typist.tech/projects/wp-better-settings
 * @see https://github.com/TypistTech/wp-better-settings
 */

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

/* @var \ArrayObject $context Context passed through from Menu_Pages class. */

$snakecased_menu_slug = str_replace('-', '_', $context->menu_slug);

do_action($snakecased_menu_slug . '_before_page_title');

echo '<h1>' . esc_html($context->page_title) . '</h1>';

do_action($snakecased_menu_slug . '_after_page_title');

echo '<h2 class="nav-tab-wrapper">';
foreach ((array) $context->tabs as $tab) {
    $active = '';
    if ($context->menu_slug === $tab->menu_slug) {
        $active = ' nav-tab-active';
    }

    echo sprintf(
        '<a href="%1$s" class="nav-tab%2$s" id="%3$s-tab">%4$s</a>',
        esc_url($tab->url()),
        esc_attr($active),
        esc_attr($tab->menu_slug),
        esc_html($tab->menu_title)
    );
}
echo '</h2>';

do_action($snakecased_menu_slug . '_after_nav_tabs');

include __DIR__ . '/options-form.php';
