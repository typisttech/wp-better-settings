<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

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
    public function it_renders()
    {
        $render = $this->subject->getRenderClosure();

        ob_start();
        $render();
        $actual = ob_get_clean();

        $this->assertSame(
            '<p id="my-id">My Title</p>',
            $actual
        );
    }
}
