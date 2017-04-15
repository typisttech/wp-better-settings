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
    use AttributeGetterTrait;
    use ConstructWithAttributesTrait;
    use ConstructWithMinimalAttributesTrait;
    use PageTraitTestTrait;

    /**
     * @var MenuPage
     */
    private $menuPage;

    /**
     * @var ViewInterface
     */
    private $view;

    public function attributeGetterProvider(): array
    {
        return [
            'iconUrl' => [ 'getIconUrl', 'dashicons-shield' ],
            'position' => [ 'getPosition', 99 ],
        ];
    }

    public function attributesProvider(): array
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

    /**
     * @covers ::__construct
     */
    public function testConstructWithDefaultViewAttribute()
    {
        $expected = ViewFactory::build('tabbed-options-page');

        $this->assertAttributeEquals($expected, 'view', $this->getMinimalSubject());
    }

    protected function getMinimalSubject()
    {
        return new MenuPage('my-menu-slug', 'My Menu Title');
    }

    public function minimalAttributesProvider(): array
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
     * @covers ::__construct
     */
    public function testConstructWithViewAttribute()
    {
        $this->assertAttributeSame($this->view, 'view', $this->menuPage);
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

    protected function _before()
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

    protected function getSubject()
    {
        return $this->menuPage;
    }
}
