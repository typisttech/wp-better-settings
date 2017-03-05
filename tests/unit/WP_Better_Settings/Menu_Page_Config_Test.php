<?php
namespace WP_Better_Settings;

/**
 * @coversDefaultClass \WP_Better_Settings\Menu_Page_Config
 */
class Menu_Page_Config_Test extends \Codeception\Test\Unit
{
    /**
     * @test
     * @coversNothing
     */
    public function it_is_an_instance_of_config()
    {
        $config = new Menu_Page_Config;
        $this->assertInstanceOf(Config::class, $config);
    }

    /**
     * @test
     * @covers ::__construct
     */
    public function it_defaults_function_name_to_add_menu_page()
    {
        $config = new Menu_Page_Config;
        $this->assertAttributeEquals('add_menu_page', 'function_name', $config);
    }

    /**
     * @test
     * @covers ::__construct
     */
    public function it_sets_function_name_to_add_submenu_page_with_parent_slug()
    {
        $config = new Menu_Page_Config([ 'parent_slug' => 'option.php' ]);
        $this->assertAttributeEquals('add_submenu_page', 'function_name', $config);
    }

    /**
     * @test
     * @covers ::default_config
     */
    public function it_has_default_config()
    {
        $config = new Menu_Page_Config;

        $expected_view = View_Factory::build('tabbed-options-page');

        $this->assertAttributeEquals('manage_options', 'capability', $config);
        $this->assertAttributeEquals($expected_view, 'view', $config);
    }

    /**
     * @test
     * @covers ::url
     */
    public function it_can_return_url_without_parent_slug()
    {
        $config   = new Menu_Page_Config([ 'menu_slug' => 'me' ]);
        $expected = admin_url('admin.php?page=me');
        $this->assertSame($expected, $config->url());
    }

    /**
     * @test
     * @covers ::url
     */
    public function it_can_return_url_with_parent_slug()
    {
        $config   = new Menu_Page_Config([ 'parent_slug' => 'father', 'menu_slug' => 'son' ]);
        $expected = admin_url('admin.php?page=son');
        $this->assertSame($expected, $config->url());
    }
}
