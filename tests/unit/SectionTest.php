<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

use AspectMock\Test;
use Codeception\Test\Unit;
use TypistTech\WPBetterSettings\Fields\Email;
use TypistTech\WPBetterSettings\Fields\Text;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\Section
 */
class SectionTest extends Unit
{
    use AttributeGetterTrait;
    use ConstructWithAttributesTrait;
    use ConstructWithMinimalAttributesTrait;
    use ExtraAwareUnitTestTrait;
    use ViewAwareUnitTestTrait;

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
            'description' => [ 'getDescription', 'My Section Description' ],
            'page' => [ 'getPage', 'my-page-slug' ],
            'title' => [ 'getTitle', 'My Section Title' ],
        ];
    }

    public function attributesProvider(): array
    {
        return [
            'page' => [ 'page', 'my-page-slug' ],
            'title' => [ 'title', 'My Section Title' ],
            'extra' => [
                'extra',
                [
                    'desc' => 'My Section Description',
                ],
            ],
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
        $this->viewFactory->verifyInvokedOnce('build', [ 'section' ]);
    }

    protected function getMinimalSubject()
    {
        return new Section('my-page-slug', 'My Section Title', [ $this->textField, $this->emailField ]);
    }

    public function minimalAttributesProvider(): array
    {
        return [
            'page' => [ 'page', 'my-page-slug' ],
            'title' => [ 'title', 'My Section Title' ],
            'extra' => [ 'extra', [] ],
        ];
    }

    /**
     * @covers ::__construct
     */
    public function testConstructWithViewAttribute()
    {
        $this->assertAttributeEquals($this->view, 'view', $this->section);
        $this->viewFactory->verifyNeverInvoked('build');
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
        $this->view = Test::double(View::class)->make();
        $this->viewFactory = Test::double(ViewFactory::class, [
            'build' => $this->view,
        ]);

        $this->section = new Section(
            'my-page-slug',
            'My Section Title',
            [
                $this->textField,
                $this->emailField,
            ],
            [
                'desc' => 'My Section Description',
            ],
            $this->view
        );
    }

    protected function getSubject()
    {
        return $this->section;
    }
}
