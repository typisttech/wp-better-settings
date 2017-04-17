<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

use AspectMock\Test;
use Codeception\Test\Unit;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\MenuPage
 */
class MenuPageTest extends Unit
{
    use AttributeGetterTrait;
    use ConstructWithAttributesTrait;
    use ConstructWithMinimalAttributesTrait;
    use ExtraAwareUnitTestTrait;
    use PageUnitTestTrait;
    use ViewAwareUnitTestTrait;

    /**
     * @var MenuPage
     */
    private $menuPage;

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
        $actual = $this->getMinimalSubject();

        $this->assertAttributeEquals($this->view, 'view', $actual);
        $this->viewFactory->verifyInvokedMultipleTimes('build', 1);
        $this->viewFactory->verifyInvokedOnce('build', [ 'tabbed-page' ]);
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
        $this->assertAttributeEquals($this->view, 'view', $this->menuPage);
        $this->viewFactory->verifyNeverInvoked('build');
    }

    protected function _before()
    {
        $this->view = Test::double(View::class)->make();
        $this->viewFactory = Test::double(ViewFactory::class, [
            'build' => $this->view,
        ]);

        $this->menuPage = new MenuPage(
            'my-menu-slug',
            'My Menu Title',
            'My Page Title',
            'promote_users',
            'dashicons-shield',
            99,
            $this->view
        );
    }

    protected function getSubject()
    {
        return $this->menuPage;
    }
}
