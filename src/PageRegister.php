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

/**
 * Final class PageRegister
 *
 * This class registers menu pages and submenu pages via the WordPress API.
 *
 * It enables you an entire collection of menu pages and submenu pages as
 * represented by your MenuPageConfig objects. In this way, you
 * don't have to deal with all the confusing callback code that the
 * WordPress Settings API forces you to use.
 */
final class PageRegister
{
    /**
     * Array of MenuPage instances.
     *
     * @var MenuPage[];
     */
    private $menuPages;

    /**
     * Array of SubmenuPage instances.
     *
     * @var SubmenuPage[];
     */
    private $submenuPages;

    /**
     * MenuPageRegister constructor.
     *
     * @param (MenuPage|SubmenuPage)[] $pages MenuPage or SubmenuPage objects that contains page configurations.
     */
    public function __construct(array $pages)
    {
        $menuPages = array_filter($pages, function ($page) {
            return $page instanceof MenuPage;
        });
        $this->menuPages = array_values($menuPages);

        $submenuPages = array_filter($pages, function ($page) {
            return $page instanceof SubmenuPage;
        });
        $this->submenuPages = array_values($submenuPages);
    }

    /**
     * Add the pages from the configuration objects to the WordPress admin
     * backend. Parent menu pages are invoked first, then submenu pages.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->menuPages as $menuPage) {
            $menuPage->setTabs($this->getPages());

            add_menu_page(
                $menuPage->getPageTitle(),
                $menuPage->getMenuTitle(),
                $menuPage->getCapability(),
                $menuPage->getMenuSlug(),
                $menuPage->getCallbackFunction(),
                $menuPage->getIconUrl(),
                $menuPage->getPosition()
            );
        }

        foreach ($this->submenuPages as $submenuPage) {
            $submenuPage->setTabs($this->getPages());

            add_submenu_page(
                $submenuPage->getParentSlug(),
                $submenuPage->getPageTitle(),
                $submenuPage->getMenuTitle(),
                $submenuPage->getCapability(),
                $submenuPage->getMenuSlug(),
                $submenuPage->getCallbackFunction()
            );
        }
    }

    /**
     * Return all menu pages and submenu page objects.
     *
     * @return (MenuPage|SubmenuPage)[]
     */
    private function getPages(): array
    {
        return array_merge($this->menuPages, $this->submenuPages);
    }
}
