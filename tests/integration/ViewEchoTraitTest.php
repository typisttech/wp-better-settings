<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\ViewEchoTrait
 */
class ViewEchoTraitTest extends \Codeception\TestCase\WPTestCase
{
    /**
     * @covers ::echoView
     */
    public function testEchoInvalidView()
    {
        $mock = $this->getMockForTrait(ViewEchoTrait::class);
        $mock->desc = '<p>Some text</p>';
        $mock->view = 1234;

        // Expect no output.
        $this->expectOutputString(null);
        $mock->echoView();
    }

    /**
     * @covers ::echoView
     */
    public function testEchoView()
    {
        $mock = $this->getMockForTrait(ViewEchoTrait::class);
        $mock->desc = '<p>Some text</p>';
        $mock->view = new View(codecept_root_dir() . 'src/partials/section-description.php');

        $this->expectOutputString('<p>Some text</p>');
        $mock->echoView();
    }

    /**
     * @covers ::echoView
     */
    public function testEchoViewFilePathAsView()
    {
        $mock = $this->getMockForTrait(ViewEchoTrait::class);
        $mock->desc = '<p>Some text</p>';
        $mock->view = codecept_root_dir() . 'src/partials/section-description.php';

        $this->expectOutputString('<p>Some text</p>');
        $mock->echoView();
    }
}
