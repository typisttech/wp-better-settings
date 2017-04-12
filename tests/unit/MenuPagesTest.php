<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

use ArrayObject;
use AspectMock\Test;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\MenuPages
 */
class MenuPagesTest extends \Codeception\Test\Unit
{
    /**
     * @covers ::adminMenu
     */
    public function testAdminMenuInvokeParentPagesFirst()
    {
        $parentMenu1 = new ArrayObject;
        $parentMenu2 = new ArrayObject;
        $submenu1 = new ArrayObject;
        $submenu1['parent_slug'] = 'options.php';
        $submenu2 = new ArrayObject;
        $submenu2['parent_slug'] = 'abc';
        $submenu3 = new ArrayObject;
        $submenu3['parent_slug'] = 'xyz';
        $menuPageConfigs = [
            $submenu1,
            $submenu3,
            $parentMenu1,
            $submenu2,
            $parentMenu2,
        ];
        $menuPage = new MenuPages($menuPageConfigs);

        $expectedOrder = [
            $parentMenu1,
            $parentMenu2,
            $submenu2,
            $submenu1,
            $submenu3,
        ];

        $arrayWalk = Test::func(__NAMESPACE__, 'array_walk', true);

        $menuPage->adminMenu();

        $arrayWalk->verifyInvokedMultipleTimes(1);
        $arrayWalk->verifyInvokedOnce([ $expectedOrder, [ $menuPage, 'addMenuPage' ] ]);
    }
}
