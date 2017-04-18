<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings\Pages;

use Codeception\Test\Unit;
use TypistTech\WPBetterSettings\AttributeGetterTrait;
use TypistTech\WPBetterSettings\ConstructWithAttributesTrait;
use TypistTech\WPBetterSettings\ConstructWithMinimalAttributesTrait;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\Pages\MenuPage
 */
class MenuPageTest extends Unit
{
    use AttributeGetterTrait;
    use ConstructWithAttributesTrait;
    use ConstructWithMinimalAttributesTrait;
    use PageTestTrait;

    /**
     * @var MenuPage
     */
    private $menuPage;

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

    protected function getSubject()
    {
        return $this->menuPage;
    }

    protected function _before()
    {
        $this->menuPage = new MenuPage(
            'my-menu-slug',
            'My Menu Title',
            'My Page Title',
            'promote_users',
            'dashicons-shield',
            99
        );
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
}
