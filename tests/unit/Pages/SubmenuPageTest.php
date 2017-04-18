<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings\Pages;

use Codeception\Test\Unit;
use TypistTech\WPBetterSettings\AttributeGetterTrait;
use TypistTech\WPBetterSettings\ConstructWithAttributesTrait;
use TypistTech\WPBetterSettings\ConstructWithMinimalAttributesTrait;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\Pages\SubmenuPage
 */
class SubmenuPageTest extends Unit
{
    use AttributeGetterTrait;
    use ConstructWithAttributesTrait;
    use ConstructWithMinimalAttributesTrait;
    use PageTestTrait;

    /**
     * @var SubmenuPage
     */
    private $submenuPage;

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

    protected function getSubject()
    {
        return $this->submenuPage;
    }

    protected function _before()
    {
        $this->submenuPage = new SubmenuPage(
            'my-parent-slug',
            'my-menu-slug',
            'My Menu Title',
            'My Page Title',
            'promote_users'
        );
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
}
