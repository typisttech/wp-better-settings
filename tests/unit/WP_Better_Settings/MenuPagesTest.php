<?php
namespace WP_Better_Settings;

use ArrayObject;
use phpmock\phpunit\PHPMock;

/**
 * @coversDefaultClass \WPBS\Menu_Pages
 */
class MenuPagesTest extends \Codeception\Test\Unit
{
    use PHPMock;

    /**
     * @covers ::admin_menu
     */
    public function testAdminMenuInvokeParentPagesFirst()
    {
        $parentMenu1             = new ArrayObject;
        $parentMenu2             = new ArrayObject;
        $submenu1                = new ArrayObject;
        $submenu1['parent_slug'] = 'options.php';
        $submenu2                = new ArrayObject;
        $submenu2['parent_slug'] = 'abc';
        $submenu3                = new ArrayObject;
        $submenu3['parent_slug'] = 'xyz';
        $menuPageConfigs         = [
            $submenu1,
            $submenu3,
            $parentMenu1,
            $submenu2,
            $parentMenu2,
        ];
        $menuPage                = new Menu_Pages($menuPageConfigs);

        $expectedOrder = [
            $parentMenu1,
            $parentMenu2,
            $submenu2,
            $submenu1,
            $submenu3,
        ];

        $arrayWalk = $this->getFunctionMock(__NAMESPACE__, 'array_walk');
        $arrayWalk->expects($this->once())
                  ->with(
                      $this->identicalTo($expectedOrder),
                      $this->identicalTo([ $menuPage, 'add_menu_page' ])
                  );

        $menuPage->admin_menu();
    }
}
