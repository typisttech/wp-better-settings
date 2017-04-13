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

use ArrayObject;

/**
 * Class MenuPages.
 *
 * This class registers menu pages via the WordPress API.
 *
 *
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
     * @var ArrayObject[];
     */
    protected $menuPageConfigs;

    /**
     * Menu_Pages constructor.
     *
     * @param ArrayObject[] $menuPageConfigs Array of config objects that contains
     *                                       menu page configurations.
     */
    public function __construct(array $menuPageConfigs)
    {
        $this->menuPageConfigs = $menuPageConfigs;
    }

    /**
     * Add the pages from the configuration objects to the WordPress admin
     * backend. Parent pages are invoked first.
     *
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
     * @param ArrayObject $menuPageConfig Arguments for the menu page creation function.
     *
     * @throws \InvalidArgumentException If the function cannot be invoked.
     *
     * @return void
     */
    protected function addMenuPage(ArrayObject $menuPageConfig)
    {
        $menuPageConfig->tabs = $this->menuPageConfigs;
        $this->invokeFunction($menuPageConfig->function_name, $menuPageConfig);
    }

    /**
     * Compare two ArrayObject by their parent_slug.
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
