<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

use AdamWathan\Form\FormBuilder;
use AspectMock\Test;
use Codeception\TestCase\WPTestCase;

/**
 * @covers \TypistTech\WPBetterSettings\Registrar
 */
class RegistrarTest extends WPTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->addSettingsSection = Test::func(__NAMESPACE__, 'add_settings_section', true);
        $this->addSettingsField = Test::func(__NAMESPACE__, 'add_settings_field', true);

        $this->builder = new FormBuilder();

        $this->subject = new Registrar('my-page');
    }

    /** @test */
    public function it_holds_page_slug()
    {
        $this->assertAttributeSame(
            'my-page',
            'pageSlug',
            $this->subject
        );
    }

    /** @test */
    public function it_holds_sections()
    {
        $sections = [
            new Section(
                'my-section-1',
                'My Section One'
            ),
            new Section(
                'my-section-2',
                'My Section Two'
            ),
        ];

        $this->subject->add(...$sections);

        $this->assertAttributeSame(
            $sections,
            'sections',
            $this->subject
        );
    }

    /** @test */
    public function it_register_sections_with_wordpress()
    {
        $this->subject->add(
            new Section(
                'my-section-1',
                'My Section One'
            ),
            new Section(
                'my-section-2',
                'My Section Two'
            )
        );

        $this->subject->run();

        $this->addSettingsSection->verifyInvokedMultipleTimes(2);
        $this->assertArraySubset(
            [
                [
                    0 => 'my-section-1',
                    1 => 'My Section One',
                    3 => 'my-page',
                ],
                [
                    0 => 'my-section-2',
                    1 => 'My Section Two',
                    3 => 'my-page',
                ],
            ],
            $this->addSettingsSection->getCallsForMethod('add_settings_section')
        );
    }

    /** @test */
    public function it_register_fields_with_wordpress()
    {
        $section1 = new Section(
            'my-section-1',
            'My Section One'
        );
        $section1->add(
            new Field(
                'my_text',
                'My Text',
                $this->builder->text('my_text')
                              ->addClass('regular-text')
                              ->required()
            ),
            new Field(
                'my_color',
                'My Color',
                $this->builder->select('my_color')
                              ->addOption('red', 'Blood')
                              ->addOption('blue', 'Sky')
                              ->addOption('green', 'Grass')
            )
        );
        $section2 = new Section(
            'my-section-2',
            'My Section Two'
        );
        $section2->add(
            new Field(
                'my_checkbox',
                'My Checkbox',
                $this->builder->checkbox('my_checkbox')
            )
        );
        $this->subject->add($section1, $section2);

        $this->subject->run();

        $this->addSettingsField->verifyInvokedMultipleTimes(3);
        $this->assertArraySubset(
            [
                [
                    0 => 'my_text',
                    1 => 'My Text',
                    3 => 'my-page',
                    4 => 'my-section-1',
                    5 => [
                        'label_for' => 'my_text',
                    ],
                ],
                [
                    0 => 'my_color',
                    1 => 'My Color',
                    3 => 'my-page',
                    4 => 'my-section-1',
                    5 => [
                        'label_for' => 'my_color',
                    ],
                ],
                [
                    0 => 'my_checkbox',
                    1 => 'My Checkbox',
                    3 => 'my-page',
                    4 => 'my-section-2',
                    5 => [
                        'label_for' => 'my_checkbox',
                    ],
                ],
            ],
            $this->addSettingsField->getCallsForMethod('add_settings_field')
        );
    }
}
