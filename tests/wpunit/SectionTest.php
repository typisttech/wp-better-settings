<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

use AdamWathan\Form\FormBuilder;
use Codeception\TestCase\WPTestCase;
use TypistTech\WPKsesView\ViewAwareTraitInterface;

/**
 * @covers \TypistTech\WPBetterSettings\Section
 */
class SectionTest extends WPTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->subject = new Section('my-id', 'My Title');
    }

    /** @test */
    public function it_is_an_instance_of_section_interface()
    {
        $this->assertInstanceOf(SectionInterface::class, $this->subject);
    }

    /** @test */
    public function it_is_an_instance_of_view_aware_trait_interface()
    {
        $this->assertInstanceOf(ViewAwareTraitInterface::class, $this->subject);
    }

    /** @test */
    public function it_has_id_getter()
    {
        $this->assertSame(
            'my-id',
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
    public function it_defaults_render_nothing()
    {
        $render = $this->subject->getRenderClosure();

        ob_start();
        $render();
        $actual = ob_get_clean();

        $this->assertEmpty($actual);
    }

    /** @test */
    public function it_holds_fields()
    {
        $builder = new FormBuilder();
        $field1 = new Field(
            'my_text',
            'My Text',
            $builder->text('my_text')
        );
        $field2 = new Field(
            'my_color',
            'My Color',
            $builder->select('my_color')
        );
        $field3 = new Field(
            'my_checkbox',
            'My Checkbox',
            $builder->checkbox('my_checkbox')
        );

        $this->subject->add($field1, $field2);
        $this->subject->add($field3);

        $this->assertAttributeSame(
            [$field1, $field2, $field3],
            'fields',
            $this->subject
        );
    }

    /** @test */
    public function it_has_fields_getter()
    {
        $builder = new FormBuilder();
        $field1 = new Field(
            'my_text',
            'My Text',
            $builder->text('my_text')
        );
        $field2 = new Field(
            'my_color',
            'My Color',
            $builder->select('my_color')
        );
        $field3 = new Field(
            'my_checkbox',
            'My Checkbox',
            $builder->checkbox('my_checkbox')
        );

        $this->subject->add($field1, $field2);
        $this->subject->add($field3);

        $this->assertSame(
            [$field1, $field2, $field3],
            $this->subject->getFields()
        );
    }
}
