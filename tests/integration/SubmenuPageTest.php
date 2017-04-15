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
    use AttributeGetterTrait;
    use ConstructWithAttributesTrait;
    use ConstructWithMinimalAttributesTrait;
    use PageTraitTestTrait;

    /**
     * @var SubmenuPage
     */
    private $submenuPage;

    /**
     * @var ViewInterface
     */
    private $view;

    public function attributeGetterProvider(): array
    {
        return [
            'parentSlug' => [ 'getParentSlug', 'my-parent-slug' ],
        ];
    }

    public function attributesProvider(): array
    {
        return [
            'parentSlug' => [ 'parentSlug', 'my-parent-slug' ],
            'menuSlug' => [ 'menuSlug', 'my-menu-slug' ],
            'menuTitle' => [ 'menuTitle', 'My Menu Title' ],
            'pageTitle' => [ 'pageTitle', 'My Page Title' ],
            'capability' => [ 'capability', 'promote_users' ],
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
        return new SubmenuPage('my-parent-slug', 'my-menu-slug', 'My Menu Title');
    }

    public function minimalAttributesProvider(): array
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
     * @covers ::__construct
     */
    public function testConstructWithViewAttribute()
    {
        $this->assertAttributeSame($this->view, 'view', $this->submenuPage);
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

    protected function _before()
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

    protected function getSubject()
    {
        return $this->submenuPage;
    }
}
