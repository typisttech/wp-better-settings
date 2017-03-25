<?php

namespace TypistTech\WPBetterSettings;

use ArrayObject;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\View
 */
class ViewTest extends \Codeception\Test\Unit
{
    /**
     * @covers ::echoKses
     */
    public function testEchoKsesOutputString()
    {
        $context       = new ArrayObject;
        $context->desc = '<p>Some text</p>';

        $view = new View(codecept_root_dir() . 'src/partials/section-description.php');

        $this->expectOutputString('<p>Some text</p>');
        $view->echoKses($context);
    }

    /**
     * @covers ::render
     */
    public function testRenderUnreadableFile()
    {
        $view   = new View(codecept_root_dir() . '/not-exist.php');
        $actual = $view->render(new ArrayObject);
        $this->assertSame('', $actual);
    }

    /**
     * @covers ::render
     */
    public function testRenderWithContext()
    {
        $context       = new ArrayObject;
        $context->desc = '<p>Some text</p>';

        $view   = new View(codecept_root_dir() . 'src/partials/section-description.php');
        $actual = $view->render($context);

        $expected = '<p>Some text</p>';

        $this->assertSame($expected, $actual);
    }
}
