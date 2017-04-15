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
 * Final class MenuPageConfig.
 *
 * Config details for a single menu page.
 */
final class MenuPage
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
     * The URL to the icon to be used for this menu.
     *
     * @var string
     */
    private $iconUrl;

    /**
     * The position in the menu order this one should appear.
     *
     * @var int|null
     */
    private $position;

    /**
     * MenuPage constructor.
     *
     * @param string             $menuSlug   The slug name to refer to this menu by (should be unique for this menu).
     * @param string             $menuTitle  The text to be displayed in the title tags of the page when the menu is
     *                                       selected.
     * @param ViewInterface|null $view       Optional. View object to render.
     * @param string|null        $pageTitle  Optional. The text to be used for the menu.
     * @param string|null        $capability Optional. The capability required for this menu to be displayed to the
     *                                       user.
     * @param string|null        $iconUrl    Optional. The URL to the icon to be used for this menu.
     * @param int|null           $position   Optional. The position in the menu order this one should appear.
     */
    public function __construct(
        string $menuSlug,
        string $menuTitle,
        ViewInterface $view = null,
        string $pageTitle = null,
        string $capability = null,
        string $iconUrl = null,
        int $position = null
    ) {
        $this->menuSlug = $menuSlug;
        $this->menuTitle = $menuTitle;

        $this->view = $view ?? ViewFactory::build('tabbed-options-page');
        $this->pageTitle = $pageTitle ?? $menuTitle;
        $this->capability = $capability ?? 'manage_options';
        $this->iconUrl = $iconUrl ?? '';
        $this->position = $position ?? null;
    }

    /**
     * IconUrl getter.
     *
     * @return string
     */
    public function getIconUrl(): string
    {
        return $this->iconUrl;
    }

    /**
     * Position getter.
     *
     * @return int|null
     */
    public function getPosition()
    {
        return $this->position;
    }
}
