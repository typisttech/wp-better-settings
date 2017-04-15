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
 * Final class SubmenuPage
 *
 * Config details for a single submenu page.
 */
final class SubmenuPage
{
    use PageTrait;
    // TODO: Test ViewEchoTrait.
    use ViewEchoTrait;

    /**
     * ViewInterface object to render.
     * Or, string of path to view partial.
     *
     * @todo Move to ViewEchoTrait.
     *
     * @var ViewInterface|string
     */
    protected $view;

    /**
     * The slug name for the parent menu
     * (or the file name of a standard WordPress admin page).
     *
     * @var string
     */
    private $parentSlug;

    /**
     * MenuPage constructor.
     *
     * @param string             $parentSlug The slug name for the parent menu (or the file name of a standard
     *                                       WordPress
     *                                       admin page).
     * @param string             $menuSlug   The slug name to refer to this menu by (should be unique for this menu).
     * @param string             $menuTitle  The text to be displayed in the title tags of the page when the menu is
     *                                       selected.
     * @param ViewInterface|null $view       View object to render.
     * @param string|null        $pageTitle  Optional. The text to be used for the menu.
     * @param string|null        $capability Optional. The capability required for this menu to be displayed to the
     *                                       user.
     */
    public function __construct(
        string $parentSlug,
        string $menuSlug,
        string $menuTitle,
        ViewInterface $view = null,
        string $pageTitle = null,
        string $capability = null
    ) {
        $this->parentSlug = $parentSlug;
        $this->menuSlug = $menuSlug;
        $this->menuTitle = $menuTitle;

        $this->view = $view ?? ViewFactory::build('tabbed-options-page');
        $this->pageTitle = $pageTitle ?? $menuTitle;
        $this->capability = $capability ?? 'manage_options';
    }

    /**
     * Returns the function to be called to output the content for this page.
     *
     * @todo Move to ViewEchoTrait.
     *
     * @return callable
     */
    public function getCallbackFunction(): callable
    {
        return [ $this, 'echoView' ];
    }

    /**
     * ParentSlug getter.
     *
     * @return string
     */
    public function getParentSlug(): string
    {
        return $this->parentSlug;
    }
}
