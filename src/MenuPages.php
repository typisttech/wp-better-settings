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

use ArrayObject;

/**
 * Class MenuPages.
 *
 * This class registers menu pages via the WordPress API.
 *
 * @since 0.1.0
 *
 * It enables you an entire collection of menu pages as as hierarchical
 * representation in your Menu_Page_Config objects. In this way, you
 * don't have to deal with all the confusing callback code that the
 * WordPress Settings API forces you to use.
 */
class MenuPages
{
    use FunctionInvokerTrait;

    /**
     * Array of Config instance.
     *
     * @since 0.1.0
     *
     * @var ArrayObject[];
     */
    protected $menuPageConfigs;

    /**
     * Menu_Pages constructor.
     *
     * @since 0.1.0
     *
     * @param ArrayObject[] $menuPageConfigs   Array of config objects that contains
     *                                         menu page configurations.
     */
    public function __construct(array $menuPageConfigs)
    {
        $this->menuPageConfigs = $menuPageConfigs;
    }

    /**
     * Add the pages from the configuration objects to the WordPress admin
     * backend. Parent pages are invoked first.
     *
     * @since 0.1.0
     * @return void
     */
    public function adminMenu()
    {
        // Parent pages must be added before submenu pages.
        usort($this->menuPageConfigs, [ $this, 'compareParentSlug' ]);
        array_walk($this->menuPageConfigs, [ $this, 'addMenuPage' ]);
    }

    /**
     * Add a single page to the WordPress admin backend.
     *
     * @since 0.1.0
     *
     * @param ArrayObject $menuPageConfig Arguments for the menu page creation function.
     *
     * @return void
     * @throws \InvalidArgumentException If the function cannot be invoked.
     */
    protected function addMenuPage(ArrayObject $menuPageConfig)
    {
        $menuPageConfig->tabs = $this->menuPageConfigs;
        $this->invokeFunction($menuPageConfig->function_name, $menuPageConfig);
    }

    /**
     * Compare two ArrayObject by their parent_slug.
     *
     * @since  0.5.1
     * @access private
     *
     * @param ArrayObject $first The first to be compared.
     * @param ArrayObject $other The other to be compared.
     *
     * @return int
     */
    private function compareParentSlug(ArrayObject $first, ArrayObject $other): int
    {
        $firstParentSlug = empty($first['parent_slug']) ? '' : $first['parent_slug'];
        $otherParentSlug = empty($other['parent_slug']) ? '' : $other['parent_slug'];

        return strcmp($firstParentSlug, $otherParentSlug);
    }
}
