<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

use AspectMock\Test;
use Codeception\Test\Unit;
use TypistTech\WPBetterSettings\Fields\Email;
use TypistTech\WPBetterSettings\Fields\Text;

/**
 * @covers \TypistTech\WPBetterSettings\Section
 * @coversDefaultClass \TypistTech\WPBetterSettings\Section
 */
class SectionTest extends Unit
{
    use AttributeGetterTrait;
    use ConstructWithAttributesTrait;

    /**
     * @var Email
     */
    private $emailField;

    /**
     * @var Section
     */
    private $section;

    /**
     * @var Text
     */
    private $textField;

    public function attributeGetterProvider(): array
    {
        return [
            'page' => [ 'getPage', 'my-page-slug' ],
            'title' => [ 'getTitle', 'My Section Title' ],
        ];
    }

    public function attributesProvider(): array
    {
        return [
            'page' => [ 'page', 'my-page-slug' ],
            'title' => [ 'title', 'My Section Title' ],
        ];
    }

    protected function getSubject()
    {
        return $this->section;
    }

    /**
     * @covers ::getFields
     */
    public function testGetFields()
    {
        $actual = $this->section->getFields();
        $expected = [ $this->textField, $this->emailField ];

        $this->assertSame($expected, $actual);
    }

    protected function _before()
    {
        $this->textField = Test::double(Text::class)->make();
        $this->emailField = Test::double(Email::class)->make();

        $this->section = new Section(
            'my-page-slug',
            'My Section Title',
            $this->textField,
            $this->emailField
        );
    }
}
