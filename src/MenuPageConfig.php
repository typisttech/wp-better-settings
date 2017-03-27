<?php
/**
 * WP Better Settings
 *
 * A simplified OOP implementation of the WP Settings API.
 *
 * @package   TypistTech\WPBetterSettings
 * @author    Typist Tech <wp-better-settings@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   GPL-2.0+
 * @see       https://www.typist.tech/projects/wp-better-settings
 * @see       https://github.com/TypistTech/wp-better-settings
 */

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

/**
 * Class MenuPageConfig.
 *
 * Config details for a single page.
 *
 * Valid keys for both top-level menu pages and submenu pages:
 *
 * 'page_title' (string)  => The text to be displayed in the
 *                           title tags of the page when the
 *                           menu is selected.
 *
 * 'menu_title' (string)  => The text to be used for the menu.
 *
 * 'capability' (string)  => The capability required for this menu to
 *                           be displayed to the user.
 *
 * 'menu_slug' (string)   => The slug name to refer to this menu by
 *                           (should be unique for this menu).
 *
 * 'view' (string|View)   => View to be used to render the element.
 *                           Can be a path to a view file or an
 *                           instance of a View class.
 *
 * Valid keys for top-level menu pages only:
 *
 * 'icon_url' (string)    => Optional. The URL to the icon to be
 *                           used for this menu, a base64-encoded
 *                           SVG, a Dashicons class, or 'none'
 *                           for an empty style-able div.
 *
 * 'position' (int)       => The position in the menu order this
 *                           page should appear.
 *
 * Valid keys for submenu pages only:
 *
 * 'parent_slug' (string) => The slug name for the parent menu (or the file
 *                           name of a standard WordPress admin page).
 *
 * @since 0.1.0
 */
class MenuPageConfig extends Config
{
    use ViewEchoTrait;

    /**
     * Menu_Page_Config constructor.
     *
     * @since 0.1.0
     *
     * @param array $config Custom config array.
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);

        // Determine which function to use:
        // add_menu_page OR add_submenu_page.
        $this->function_name = $this->function_name ?? $this->hasKey('parent_slug')
                ? 'add_submenu_page'
                : 'add_menu_page';
    }

    /**
     * Url of this menu page.
     *
     * @since 0.3.0
     *
     * @return string Admin URL link with menu slug appended.
     */
    public function url(): string
    {
        // TODO: It doesn't work for standard WordPress admin pages.
        return admin_url('admin.php?page=' . $this->menu_slug);
    }

    /**
     * Default config of Menu_Page_Config.
     *
     * @since 0.1.0
     *
     * @return array
     * @throws \InvalidArgumentException If the partial is not supported.
     */
    protected function defaultConfig(): array
    {
        return [
            'capability' => 'manage_options',
            'view'       => ViewFactory::build('tabbed-options-page'),
            'function'   => [ $this, 'echoView' ],
        ];
    }
}
