<?php
namespace WPBS\WP_Better_Settings;

/**
 * @coversDefaultClass \WPBS\WP_Better_Settings\View_Echo_Trait
 */
class View_Echo_TraitTest extends \Codeception\Test\Unit
{
    /**
     * @covers ::echo_view
     */
    public function testEchoView()
    {
        $mock       = $this->getMockForTrait(View_Echo_Trait::class);
        $mock->desc = '<p>Some text</p>';
        $mock->view = new View(codecept_root_dir() . 'src/wp-better-settings/partials/section-description.phtml');

        $this->expectOutputString('<p>Some text</p>');
        $mock->echo_view();
    }

    /**
     * @covers ::echo_view
     */
    public function testEchoViewFilePathAsView()
    {
        $mock       = $this->getMockForTrait(View_Echo_Trait::class);
        $mock->desc = '<p>Some text</p>';
        $mock->view = codecept_root_dir() . 'src/wp-better-settings/partials/section-description.phtml';

        $this->expectOutputString('<p>Some text</p>');
        $mock->echo_view();
    }

    /**
     * @covers ::echo_view
     */
    public function testEchoInvalidView()
    {
        $mock       = $this->getMockForTrait(View_Echo_Trait::class);
        $mock->desc = '<p>Some text</p>';
        $mock->view = 1234;

        // Expect no output.
        $this->expectOutputString(null);
        $mock->echo_view();
    }
}
