<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

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
                    'my-section-1',
                    'My Section One',
                ],
                [
                    'my-section-2',
                    'My Section Two',
                ],
            ],
            $this->addSettingsSection->getCallsForMethod('add_settings_section')
        );
    }

    /** @test */
    public function it_register_sections_using_page_slug()
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
        foreach ($this->addSettingsSection->getCallsForMethod('add_settings_section') as $params) {
            $this->tester->assertContains(
                'my-page',
                $params
            );
        }
    }

    /** @test */
    public function it_register_fields_with_wordpress()
    {
        $this->markTestIncomplete();
    }
}
