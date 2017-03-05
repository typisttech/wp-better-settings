<?php
namespace WP_Better_Settings;

/**
 * @coversDefaultClass \WPBS\View_Echo_Trait
 */
class View_Echo_Trait_Test extends \Codeception\Test\Unit
{
    /**
     * @covers ::echo_view
     */
    public function testEchoView()
    {
        $mock       = $this->getMockForTrait(View_Echo_Trait::class);
        $mock->desc = '<p>Some text</p>';
        $mock->view = new View(codecept_root_dir() . 'src/partials/section-description.php');

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
        $mock->view = codecept_root_dir() . 'src/partials/section-description.php';

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
