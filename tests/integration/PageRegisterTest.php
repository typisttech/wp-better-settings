<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

use AspectMock\Test;
use Codeception\TestCase\WPTestCase;
use TypistTech\WPBetterSettings\Pages\MenuPage;
use TypistTech\WPBetterSettings\Pages\SubmenuPage;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\PageRegistrar
 */
class PageRegisterTest extends WPTestCase
{
    /**
     * @var \AspectMock\Proxy\FuncProxy
     */
    private $addMenuPage;

    /**
     * @var \AspectMock\Proxy\FuncProxy
     */
    private $addSubmenuPage;

    /**
     * @var MenuPage
     */
    private $menuPageOne;

    /**
     * @var MenuPage
     */
    private $menuPageTwo;

    /**
     * @var PageRegistrar
     */
    private $pageRegistrar;

    /**
     * @var SubmenuPage
     */
    private $submenuPageFour;

    /**
     * @var SubmenuPage
     */
    private $submenuPageThree;

    public function _before()
    {
        $this->addMenuPage = Test::func(__NAMESPACE__, 'add_menu_page', true);
        $this->addSubmenuPage = Test::func(__NAMESPACE__, 'add_submenu_page', true);

        $this->menuPageOne = new MenuPage('slug-one', 'title one');
        $this->menuPageTwo = new MenuPage('slug-two', 'title two');
        $this->submenuPageThree = new SubmenuPage('parent-slug-three', 'slug-three', 'title three');
        $this->submenuPageFour = new SubmenuPage('parent-slug-four', 'slug-four', 'title four');

        $this->pageRegistrar = new PageRegistrar(
            [
                $this->menuPageOne,
                $this->menuPageTwo,
                $this->submenuPageThree,
                $this->submenuPageFour,
            ]
        );
    }

    /**
     * @covers ::__construct
     */
    public function testConstructorSetsMenuPages()
    {
        $expected = [
            $this->menuPageOne,
            $this->menuPageTwo,
        ];

        $this->assertAttributeSame($expected, 'menuPages', $this->pageRegistrar);
    }

    /**
     * @covers ::__construct
     */
    public function testConstructorSetsSubmenuPages()
    {
        $expected = [
            $this->submenuPageThree,
            $this->submenuPageFour,
        ];

        $this->assertAttributeSame($expected, 'submenuPages', $this->pageRegistrar);
    }

    /**
     * @covers ::run
     */
    public function testRegisterMenuPages()
    {
        $this->pageRegistrar->run();

        $this->addMenuPage->verifyInvokedMultipleTimes(2);
        $this->addMenuPage->verifyInvokedOnce(
            [
                $this->menuPageOne->getPageTitle(),
                $this->menuPageOne->getMenuTitle(),
                $this->menuPageOne->getCapability(),
                $this->menuPageOne->getMenuSlug(),
                $this->menuPageOne->getCallbackFunction(),
                $this->menuPageOne->getIconUrl(),
                $this->menuPageOne->getPosition(),
            ]
        );
        $this->addMenuPage->verifyInvokedOnce(
            [
                $this->menuPageTwo->getPageTitle(),
                $this->menuPageTwo->getMenuTitle(),
                $this->menuPageTwo->getCapability(),
                $this->menuPageTwo->getMenuSlug(),
                $this->menuPageTwo->getCallbackFunction(),
                $this->menuPageTwo->getIconUrl(),
                $this->menuPageTwo->getPosition(),
            ]
        );
    }

    /**
     * @covers ::run
     */
    public function testRegisterSubmenuPages()
    {
        $this->pageRegistrar->run();

        $this->addSubmenuPage->verifyInvokedMultipleTimes(2);
        $this->addSubmenuPage->verifyInvokedOnce(
            [
                $this->submenuPageThree->getParentSlug(),
                $this->submenuPageThree->getPageTitle(),
                $this->submenuPageThree->getMenuTitle(),
                $this->submenuPageThree->getCapability(),
                $this->submenuPageThree->getMenuSlug(),
                $this->submenuPageThree->getCallbackFunction(),
            ]
        );
        $this->addSubmenuPage->verifyInvokedOnce(
            [
                $this->submenuPageFour->getParentSlug(),
                $this->submenuPageFour->getPageTitle(),
                $this->submenuPageFour->getMenuTitle(),
                $this->submenuPageFour->getCapability(),
                $this->submenuPageFour->getMenuSlug(),
                $this->submenuPageFour->getCallbackFunction(),
            ]
        );
    }

    protected function getSubject()
    {
        return $this->pageRegistrar;
    }
}
