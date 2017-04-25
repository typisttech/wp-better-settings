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

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

/* @var Decorators\Pages\TabbedPageInterface $context Context */

echo '<div class="wrap">';

do_action($context->getSnakecasedMenuSlug() . '_before_page_title');

echo '<h1>' . esc_html($context->getPageTitle()) . '</h1>';

do_action($context->getSnakecasedMenuSlug() . '_after_page_title');

do_action($context->getSnakecasedMenuSlug() . '_before_nav_tabs');

echo '<h2 class="nav-tab-wrapper">';

/* @var Decorators\Page $tab */
foreach ($context->getTabs() as $tab) {
    $active = '';
    if ($context->getMenuSlug() === $tab->getMenuSlug()) {
        $active = ' nav-tab-active';
    }

    echo sprintf(
        '<a href="%1$s" class="nav-tab%2$s" id="%3$s-tab">%4$s</a>',
        esc_url($tab->getUrl()),
        esc_attr($active),
        esc_attr($tab->getMenuSlug()),
        esc_html($tab->getMenuTitle())
    );
}
echo '</h2>';

do_action($context->getSnakecasedMenuSlug() . '_after_nav_tabs');

include __DIR__ . '/options-form.php';

echo '</div>';
