<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings\Views;

use ArrayObject;
use Codeception\TestCase\WPTestCase;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\Views\View
 */
class ViewTest extends WPTestCase
{
    /**
     * @covers ::echoKses
     */
    public function testEchoKsesOutputString()
    {
        $context = new ArrayObject();
        $context->desc = '<p>Some text</p>';

        $view = new View(codecept_data_dir() . 'test-partial.php');

        $this->expectOutputString('<p>Some text</p>');
        $view->echoKses($context);
    }

    /**
     * @covers ::render
     */
    public function testRenderUnreadableFile()
    {
        $view = new View(codecept_data_dir() . '/not-exist.php');
        $actual = $view->render(new ArrayObject());
        $this->assertSame('', $actual);
    }

    /**
     * @covers ::render
     */
    public function testRenderWithContext()
    {
        $context = new ArrayObject();
        $context->desc = '<p>Some text</p>';

        $view = new View(codecept_data_dir() . 'test-partial.php');
        $actual = $view->render($context);

        $expected = '<p>Some text</p>';

        $this->assertSame($expected, $actual);
    }
}
