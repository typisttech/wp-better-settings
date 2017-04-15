<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

use AspectMock\Test;
use Codeception\TestCase\WPTestCase;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\MenuPage
 */
class MenuPageTest extends WPTestCase
{
    use PageTraitTestTrait;

    /**
     * @var ViewInterface
     */
    public $view;

    /**
     * @var MenuPage
     */
    private $menuPage;

    public function _before()
    {
        $this->view = Test::double(View::class)->make();

        $this->menuPage = new MenuPage(
            'my-menu-slug',
            'My Menu Title',
            $this->view,
            'My Page Title',
            'promote_users',
            'dashicons-shield',
            99
        );
    }

    public function attributeGettersProvider(): array
    {
        return [
            'iconUrl' => [ 'getIconUrl', 'dashicons-shield' ],
            'position' => [ 'getPosition', 99 ],
        ];
    }

    public function configProvider(): array
    {
        return [
            'menuSlug' => [ 'menuSlug', 'my-menu-slug' ],
            'menuTitle' => [ 'menuTitle', 'My Menu Title' ],
            'pageTitle' => [ 'pageTitle', 'My Page Title' ],
            'capability' => [ 'capability', 'promote_users' ],
            'iconUrl' => [ 'iconUrl', 'dashicons-shield' ],
            'position' => [ 'position', 99 ],
        ];
    }

    public function minimalConfigProvider(): array
    {
        return [
            'menuSlug' => [ 'menuSlug', 'my-menu-slug' ],
            'menuTitle' => [ 'menuTitle', 'My Menu Title' ],
            'pageTitle' => [ 'pageTitle', 'My Menu Title' ],
            'capability' => [ 'capability', 'manage_options' ],
            'iconUrl' => [ 'iconUrl', '' ],
            'position' => [ 'position', null ],
        ];
    }

    /**
     * @covers       \TypistTech\WPBetterSettings\MenuPage
     * @dataProvider attributeGettersProvider
     *
     * @param string $getterName Getter function to be tested.
     * @param mixed  $expected   Expected attribute.
     */
    public function testAttributeGetters(string $getterName, $expected)
    {
        $actual = $this->menuPage->{$getterName}();

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers ::__construct
     * @dataProvider configProvider
     *
     * @param string $actualAttributeName Attribute to be tested.
     * @param mixed  $expected            Expected attribute.
     */
    public function testConstructWithConfig(string $actualAttributeName, $expected)
    {
        $this->assertAttributeSame($expected, $actualAttributeName, $this->menuPage);
    }

    /**
     * @covers ::__construct
     */
    public function testConstructWithConfigViewAttribute()
    {
        $this->assertAttributeSame($this->view, 'view', $this->menuPage);
    }

    /**
     * @covers ::__construct
     */
    public function testConstructWithDefaultViewAttribute()
    {
        $actual = new MenuPage('my-menu-slug', 'My Menu Title');

        $expected = ViewFactory::build('tabbed-options-page');

        $this->assertAttributeEquals($expected, 'view', $actual);
    }

    /**
     * @covers ::__construct
     * @dataProvider minimalConfigProvider
     *
     * @param string $actualAttributeName Attribute to be tested.
     * @param mixed  $expected            Expected attribute.
     */
    public function testConstructWithMinimalConfig(string $actualAttributeName, $expected)
    {
        $actual = new MenuPage('my-menu-slug', 'My Menu Title');

        $this->assertAttributeSame($expected, $actualAttributeName, $actual);
    }

    /**
     * @covers ::getCallbackFunction
     * @todo: Move to trait test
     */
    public function testGetCallbackFunction()
    {
        $actual = $this->menuPage->getCallbackFunction();

        $expected = [ $this->menuPage, 'echoView' ];

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers ::getCallbackFunction
     * @todo: Move to trait test
     */
    public function testGetCallbackFunctionIsCallable()
    {
        $actual = $this->menuPage->getCallbackFunction();

        $this->assertInternalType('callable', $actual);
    }

    protected function getSubject()
    {
        return $this->menuPage;
    }
}
