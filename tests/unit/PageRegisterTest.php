<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

use AspectMock\Test;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\PageRegister
 */
class PageRegisterTest extends \Codeception\Test\Unit
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
     * @var PageRegister
     */
    private $pageRegister;

    /**
     * @var SubmenuPage
     */
    private $submenuPageFour;

    /**
     * @var SubmenuPage
     */
    private $submenuPageThree;

    /**
     * @var ViewInterface
     */
    private $view;

    public function _before()
    {
        $this->addMenuPage = Test::func(__NAMESPACE__, 'add_menu_page', true);
        $this->addSubmenuPage = Test::func(__NAMESPACE__, 'add_submenu_page', true);

        $this->view = Test::double(View::class)->make();
        $this->menuPageOne = new MenuPage('slug-one', 'title one', $this->view);
        $this->menuPageTwo = new MenuPage('slug-two', 'title two', $this->view);
        $this->submenuPageThree = new SubmenuPage('parent-slug-three', 'slug-three', 'title three', $this->view);
        $this->submenuPageFour = new SubmenuPage('parent-slug-four', 'slug-four', 'title four', $this->view);

        $this->pageRegister = new PageRegister([
            $this->menuPageOne,
            $this->menuPageTwo,
            $this->submenuPageThree,
            $this->submenuPageFour,
        ]);
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

        $this->assertAttributeSame($expected, 'menuPages', $this->pageRegister);
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

        $this->assertAttributeSame($expected, 'submenuPages', $this->pageRegister);
    }

    /**
     * @covers ::run
     */
    public function testRegisterInvokesAddMenuPage()
    {
        $this->pageRegister->run();

        $this->addMenuPage->verifyInvokedMultipleTimes(2);
        $this->addMenuPage->verifyInvokedOnce([
            $this->menuPageOne->getPageTitle(),
            $this->menuPageOne->getMenuTitle(),
            $this->menuPageOne->getCapability(),
            $this->menuPageOne->getMenuSlug(),
            $this->menuPageOne->getCallbackFunction(),
            $this->menuPageOne->getIconUrl(),
            $this->menuPageOne->getPosition(),
        ]);
        $this->addMenuPage->verifyInvokedOnce([
            $this->menuPageTwo->getPageTitle(),
            $this->menuPageTwo->getMenuTitle(),
            $this->menuPageTwo->getCapability(),
            $this->menuPageTwo->getMenuSlug(),
            $this->menuPageTwo->getCallbackFunction(),
            $this->menuPageTwo->getIconUrl(),
            $this->menuPageTwo->getPosition(),
        ]);
    }

    /**
     * @covers ::run
     */
    public function testRegisterInvokesAddSubmenuPage()
    {
        $this->pageRegister->run();

        $this->addSubmenuPage->verifyInvokedMultipleTimes(2);
        $this->addSubmenuPage->verifyInvokedOnce([
            $this->submenuPageThree->getParentSlug(),
            $this->submenuPageThree->getPageTitle(),
            $this->submenuPageThree->getMenuTitle(),
            $this->submenuPageThree->getCapability(),
            $this->submenuPageThree->getMenuSlug(),
            $this->submenuPageThree->getCallbackFunction(),
        ]);
        $this->addSubmenuPage->verifyInvokedOnce([
            $this->submenuPageFour->getParentSlug(),
            $this->submenuPageFour->getPageTitle(),
            $this->submenuPageFour->getMenuTitle(),
            $this->submenuPageFour->getCapability(),
            $this->submenuPageFour->getMenuSlug(),
            $this->submenuPageFour->getCallbackFunction(),
        ]);
    }
}
