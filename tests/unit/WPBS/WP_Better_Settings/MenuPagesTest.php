<?php
namespace WPBS\WP_Better_Settings;

use ArrayObject;
use phpmock\phpunit\PHPMock;

/**
 * @coversDefaultClass \WPBS\WP_Better_Settings\Menu_Pages
 */
class Menu_PagesTest extends \Codeception\Test\Unit
{
    use PHPMock;

    /**
     * @covers ::admin_menu
     */
    public function testAdminMenuInvokeParentPagesFirst()
    {
        $parent_menu_1                = new ArrayObject;
        $parent_menu_2                = new ArrayObject;
        $submenu_1                  = new ArrayObject;
        $submenu_1['parent_slug']   = 'options.php';
        $submenu_2                  = new ArrayObject;
        $submenu_2['parent_slug']   = 'abc';
        $submenu_3                  = new ArrayObject;
        $submenu_3['parent_slug']   = 'xyz';
        $menu_page_configs          = [
            $submenu_1,
            $submenu_3,
            $parent_menu_1,
            $submenu_2,
            $parent_menu_2
        ];
        $menu_page = new Menu_Pages($menu_page_configs);

        $expected_order = [
            $parent_menu_1,
            $parent_menu_2,
            $submenu_2,
            $submenu_1,
            $submenu_3,
        ];

        $array_walk = $this->getFunctionMock(__NAMESPACE__, 'array_walk');
        $array_walk->expects($this->once())
                   ->with(
                       $this->identicalTo($expected_order),
                       $this->identicalTo([ $menu_page, 'add_menu_page' ])
                   );

        $menu_page->admin_menu();
    }
}
