<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

use AspectMock\Test;
use Codeception\TestCase\WPTestCase;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\SubmenuPage
 */
class SubmenuPageTest extends WPTestCase
{
    use PageTraitTestTrait;

    /**
     * @var ViewInterface
     */
    public $view;

    /**
     * @var SubmenuPage
     */
    private $submenuPage;

    public function _before()
    {
        $this->view = Test::double(View::class)->make();

        $this->submenuPage = new SubmenuPage(
            'my-parent-slug',
            'my-menu-slug',
            'My Menu Title',
            $this->view,
            'My Page Title',
            'promote_users'
        );
    }

    public function attributeGettersProvider(): array
    {
        return [
            'parentSlug' => [ 'getParentSlug', 'my-parent-slug' ],
        ];
    }

    public function configProvider(): array
    {
        return [
            'parentSlug' => [ 'parentSlug', 'my-parent-slug' ],
            'menuSlug' => [ 'menuSlug', 'my-menu-slug' ],
            'menuTitle' => [ 'menuTitle', 'My Menu Title' ],
            'pageTitle' => [ 'pageTitle', 'My Page Title' ],
            'capability' => [ 'capability', 'promote_users' ],
        ];
    }

    public function minimalConfigProvider(): array
    {
        return [
            'parentSlug' => [ 'parentSlug', 'my-parent-slug' ],
            'menuSlug' => [ 'menuSlug', 'my-menu-slug' ],
            'menuTitle' => [ 'menuTitle', 'My Menu Title' ],
            'pageTitle' => [ 'pageTitle', 'My Menu Title' ],
            'capability' => [ 'capability', 'manage_options' ],
        ];
    }

    /**
     * @covers       \TypistTech\WPBetterSettings\SubmenuPage
     * @dataProvider attributeGettersProvider
     *
     * @param string $getterName Getter function to be tested.
     * @param mixed  $expected   Expected attribute.
     */
    public function testAttributeGetters(string $getterName, $expected)
    {
        $actual = $this->submenuPage->{$getterName}();

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
        $this->assertAttributeSame($expected, $actualAttributeName, $this->submenuPage);
    }

    /**
     * @covers ::__construct
     */
    public function testConstructWithConfigViewAttribute()
    {
        $this->assertAttributeSame($this->view, 'view', $this->submenuPage);
    }

    /**
     * @covers ::__construct
     */
    public function testConstructWithDefaultViewAttribute()
    {
        $actual = new SubmenuPage('my-parent-slug', 'my-menu-slug', 'My Menu Title');

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
        $actual = new SubmenuPage('my-parent-slug', 'my-menu-slug', 'My Menu Title');

        $this->assertAttributeSame($expected, $actualAttributeName, $actual);
    }

    /**
     * @covers ::getCallbackFunction
     * @todo: Move to trait test
     */
    public function testGetCallbackFunction()
    {
        $actual = $this->submenuPage->getCallbackFunction();

        $expected = [ $this->submenuPage, 'echoView' ];

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers ::getCallbackFunction
     * @todo: Move to trait test
     */
    public function testGetCallbackFunctionIsCallable()
    {
        $actual = $this->submenuPage->getCallbackFunction();

        $this->assertInternalType('callable', $actual);
    }

    protected function getSubject()
    {
        return $this->submenuPage;
    }
}
