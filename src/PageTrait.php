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

trait PageTrait
{
    /**
     * The capability required for this menu to be displayed to the user.
     *
     * @var string
     */
    protected $capability;

    /**
     * The slug name to refer to this menu by (should be unique for this menu).
     *
     * @var string
     */
    protected $menuSlug;

    /**
     * The text to be used for the menu.
     *
     * @var string
     */
    protected $menuTitle;

    /**
     * The text to be displayed in the title tags of the page when the menu is selected.
     *
     * @var string
     */
    protected $pageTitle;

    /**
     * Array of MenuPage or SubmenuPage objects.
     *
     * @var (MenuPage|SubmenuPage)[]
     */
    private $tabs;

    /**
     * Capability getter.
     *
     * @return string
     */
    public function getCapability(): string
    {
        return $this->capability;
    }

    /**
     * MenuSlug getter.
     *
     * @return string
     */
    public function getMenuSlug(): string
    {
        return $this->menuSlug;
    }

    /**
     * MenuTitle getter.
     *
     * @return string
     */
    public function getMenuTitle(): string
    {
        return $this->menuTitle;
    }

    /**
     * PageTitle getter.
     *
     * @return string
     */
    public function getPageTitle(): string
    {
        return $this->pageTitle;
    }

    /**
     * Tabs getter.
     *
     * @return (MenuPage|SubmenuPage)[]
     */
    public function getTabs(): array
    {
        return $this->tabs;
    }

    /**
     * Tabs setter.
     *
     * @param (MenuPage|SubmenuPage)[] $tabs MenuPage or SubmenuPage objects that contains page configurations.
     *
     * @return void
     */
    public function setTabs(array $tabs)
    {
        $typedTabs = array_filter($tabs, function ($page) {
            return $page instanceof MenuPage || $page instanceof SubmenuPage;
        });
        $this->tabs = array_values($typedTabs);
    }

    /**
     * Returns the URL of this page.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return admin_url('admin.php?page=' . $this->menuSlug);
    }
}
