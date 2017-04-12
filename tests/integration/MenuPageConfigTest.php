<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\MenuPageConfig
 */
class MenuPageConfigTest extends \Codeception\TestCase\WPTestCase
{
    /**
     * @covers ::url
     */
    public function testCanReturnUrlWithParentSlug()
    {
        $config   = new MenuPageConfig([
            'parent_slug' => 'father',
            'menu_slug' => 'son',
        ]);
        $expected = admin_url('admin.php?page=son');
        $this->assertSame($expected, $config->url());
    }

    /**
     * @covers ::url
     */
    public function testCanReturnUrlWithoutParentSlug()
    {
        $config   = new MenuPageConfig([
            'menu_slug' => 'me',
        ]);
        $expected = admin_url('admin.php?page=me');
        $this->assertSame($expected, $config->url());
    }

    /**
     * @covers ::__construct
     */
    public function testDefaultsFunctionNameToAddMenuPage()
    {
        $config = new MenuPageConfig;
        $this->assertAttributeEquals('add_menu_page', 'function_name', $config);
    }

    /**
     * @covers ::defaultConfig
     */
    public function testHasDefaultConfig()
    {
        $config = new MenuPageConfig;

        $expected_view = ViewFactory::build('tabbed-options-page');

        $this->assertAttributeEquals('manage_options', 'capability', $config);
        $this->assertAttributeEquals($expected_view, 'view', $config);
    }

    /**
     * @coversNothing
     */
    public function testIsAnInstanceOfConfig()
    {
        $config = new MenuPageConfig;
        $this->assertInstanceOf(Config::class, $config);
    }

    /**
     * @covers ::__construct
     */
    public function testSetsFunctionNameToAddSubmenuPageWithParentSlug()
    {
        $config = new MenuPageConfig([
            'parent_slug' => 'option.php',
        ]);
        $this->assertAttributeEquals('add_submenu_page', 'function_name', $config);
    }
}
