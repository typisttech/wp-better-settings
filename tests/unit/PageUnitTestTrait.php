<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

trait PageUnitTestTrait
{
    abstract protected function getSubject();

    public function pageAttributeGettersProvider(): array
    {
        return [
            'menuSlug' => [ 'getMenuSlug', 'my-menu-slug' ],
            'menuTitle' => [ 'getMenuTitle', 'My Menu Title' ],
            'pageTitle' => [ 'getPageTitle', 'My Page Title' ],
            'capability' => [ 'getCapability', 'promote_users' ],
            'snakecasedMenuSlug' => [ 'getSnakecasedMenuSlug', 'my_menu_slug' ],
        ];
    }

    /**
     * @covers       \TypistTech\WPBetterSettings\PageTrait
     * @dataProvider pageAttributeGettersProvider
     *
     * @param string $getterName Getter function to be tested.
     * @param mixed  $expected   Expected attribute.
     */
    public function testPageAttributeGetters(string $getterName, $expected)
    {
        $actual = $this->getSubject()->{$getterName}();

        $this->assertSame($expected, $actual);
    }
}
