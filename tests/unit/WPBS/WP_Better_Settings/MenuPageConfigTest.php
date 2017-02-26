<?php
namespace WPBS\WP_Better_Settings;

/**
 * @coversDefaultClass \WPBS\WP_Better_Settings\Menu_Page_Config
 */
class MenuPageConfigTest extends \Codeception\Test\Unit
{
    /**
     * @coversNothing
     */
    public function testIsAnInstanceOfConfig()
    {
        $config = new Menu_Page_Config;
        $this->assertInstanceOf(Config::class, $config);
    }

    /**
     * @covers ::__construct
     */
    public function testAddMenuPage()
    {
        $config = new Menu_Page_Config;
        $this->assertAttributeEquals('add_menu_page', 'function_name', $config);
    }

    /**
     * @covers ::__construct
     */
    public function testAddSubmenuPage()
    {
        $config = new Menu_Page_Config([ 'parent_slug' => 'option.php' ]);
        $this->assertAttributeEquals('add_submenu_page', 'function_name', $config);
    }

    /**
     * @covers ::default_config
     */
    public function testDefaultConfig()
    {
        $config = new Menu_Page_Config;

        $expected_view = View_Factory::build('basic-options-page');

        $this->assertAttributeEquals('manage_options', 'capability', $config);
        $this->assertAttributeEquals($expected_view, 'view', $config);
    }

    /**
     * @covers ::url
     */
    public function testUrlWithoutParent()
    {
        $config   = new Menu_Page_Config([ 'menu_slug' => 'me' ]);
        $expected = admin_url('admin.php?page=me');
        $this->assertSame($expected, $config->url());
    }

    /**
     * @covers ::url
     */
    public function testUrlWithParent()
    {
        $config   = new Menu_Page_Config([ 'parent_slug' => 'father', 'menu_slug' => 'son' ]);
        $expected = admin_url('admin.php?page=son');
        $this->assertSame($expected, $config->url());
    }
}
