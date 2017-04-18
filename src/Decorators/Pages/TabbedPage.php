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

namespace TypistTech\WPBetterSettings\Decorators\Pages;

use TypistTech\WPBetterSettings\Pages\PageInterface;
use TypistTech\WPBetterSettings\Views\ViewAwareInterface;
use TypistTech\WPBetterSettings\Views\ViewAwareTrait;
use TypistTech\WPBetterSettings\Views\ViewFactory;
use TypistTech\WPBetterSettings\Views\ViewInterface;

/**
 * Final class Page
 *
 * This class defines necessary methods for rendering `src/partials/tabbed-page.php`.
 */
final class TabbedPage implements TabbedPageInterface, ViewAwareInterface
{
    use ViewAwareTrait;

    /**
     * All page decorators of this plugin.
     *
     * @var self[]
     */
    protected $tabs;

    /**
     * The decorated page.
     *
     * @var PageInterface
     */
    private $page;

    /**
     * Page constructor.
     *
     * @param PageInterface $page The decorated page.
     */
    public function __construct(PageInterface $page)
    {
        $this->page = $page;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultView(): ViewInterface
    {
        return ViewFactory::build('tabbed-page');
    }

    /**
     * {@inheritdoc}
     */
    public function getMenuSlug(): string
    {
        return $this->page->getMenuSlug();
    }

    /**
     * {@inheritdoc}
     */
    public function getMenuTitle(): string
    {
        return $this->page->getMenuTitle();
    }

    /**
     * {@inheritdoc}
     */
    public function getPageTitle(): string
    {
        return $this->page->getPageTitle();
    }

    /**
     * {@inheritdoc}
     */
    public function getSnakecasedMenuSlug(): string
    {
        $lowercaseMenuSlug = strtolower($this->getMenuSlug());

        return str_replace('-', '_', $lowercaseMenuSlug);
    }

    /**
     * {@inheritdoc}
     */
    public function getTabs(): array
    {
        return $this->tabs;
    }

    /**
     * Tabs setter.
     *
     * @param TabbedPageInterface|TabbedPageInterface[] ...$tabs Other pages of this plugin.
     *
     * @return void
     */
    public function setTabs(TabbedPageInterface ...$tabs)
    {
        $this->tabs = $tabs;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl(): string
    {
        return admin_url('admin.php?page=' . $this->getMenuSlug());
    }
}
