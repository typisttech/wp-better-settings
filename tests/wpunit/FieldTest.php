<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

use AdamWathan\Form\Elements\Checkbox;
use AdamWathan\Form\FormBuilder;
use Codeception\TestCase\WPTestCase;
use Codeception\Util\Stub;

/**
 * @covers \TypistTech\WPBetterSettings\Field
 */
class FieldTest extends WPTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->builder = new FormBuilder();
        $this->subject = new Field(
            'my_field_id',
            'My Title',
            $this->builder->text('my_field_id')
        );
    }

    /** @test */
    public function it_is_an_instance_of_field_interface()
    {
        $this->assertInstanceOf(FieldInterface::class, $this->subject);
    }

    /** @test */
    public function it_has_id_getter()
    {
        $this->assertSame(
            'my_field_id',
            $this->subject->getId()
        );
    }

    /** @test */
    public function it_has_title_getter()
    {
        $this->assertSame(
            'My Title',
            $this->subject->getTitle()
        );
    }

    /** @test */
    public function its_render_closure_invoke_form_control()
    {
        $formControl = Stub::makeEmpty(
            Checkbox::class,
            [
                'render' => Stub::once(
                    function () {
                        return 'Form control HTML string';
                    }
                ),
            ],
            $this
        );
        $field = new Field(
            'my_field_id',
            'My Title',
            $formControl
        );

        $render = $field->getRenderClosure();
        ob_start();
        $render();
        $actual = ob_get_clean();

        $this->assertContains(
            'Form control HTML string',
            $actual
        );
    }

    /** @test */
    public function it_has_additional_render_arguments_getter()
    {
        $expected = [
            'label_for' => 'my_field_id',
        ];

        $actual = $this->subject->getAdditionalRenderArguments();

        $this->assertSame($expected, $actual);
    }

    /** @test */
    public function it_merges_additional_render_arguments()
    {
        $field = new Field(
            'my_field_id',
            'My Title',
            $this->builder->text('my_field_id'),
            [
                'class' => 'my-class',
            ]
        );

        $actual = $field->getAdditionalRenderArguments();

        $this->assertSame(
            [
                'class' => 'my-class',
                'label_for' => 'my_field_id',
            ],
            $actual
        );
    }
}
