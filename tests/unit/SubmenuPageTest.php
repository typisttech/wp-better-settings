<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

use AspectMock\Test;
use Codeception\Test\Unit;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\SubmenuPage
 */
class SubmenuPageTest extends Unit
{
    use AttributeGetterTrait;
    use ConstructWithAttributesTrait;
    use ConstructWithMinimalAttributesTrait;
    use ExtraAwareUnitTestTrait;
    use PageUnitTestTrait;
    use ViewAwareUnitTestTrait;

    /**
     * @var SubmenuPage
     */
    private $submenuPage;

    /**
     * @var View
     */
    private $view;

    /**
     * @var \AspectMock\Proxy\ClassProxy
     */
    private $viewFactory;

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
        $actual = $this->getMinimalSubject();

        $this->assertAttributeEquals($this->view, 'view', $actual);
        $this->viewFactory->verifyInvokedMultipleTimes('build', 1);
        $this->viewFactory->verifyInvokedOnce('build', [ 'tabbed-page' ]);
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
        $this->assertAttributeEquals($this->view, 'view', $this->submenuPage);
        $this->viewFactory->verifyNeverInvoked('build');
    }

    protected function _before()
    {
        $this->view = Test::double(View::class)->make();
        $this->viewFactory = Test::double(ViewFactory::class, [
            'build' => $this->view,
        ]);

        $this->submenuPage = new SubmenuPage(
            'my-parent-slug',
            'my-menu-slug',
            'My Menu Title',
            'My Page Title',
            'promote_users',
            $this->view
        );
    }

    protected function getSubject()
    {
        return $this->submenuPage;
    }
}
