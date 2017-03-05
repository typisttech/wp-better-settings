<?php
namespace WP_Better_Settings;

use ArrayObject;

/**
 * @coversDefaultClass \WPBS\View
 */
class ViewTest extends \Codeception\Test\Unit
{
    /**
     * @covers ::echo_kses
     */
    public function testEchoKsesOutputString()
    {
        $context       = new ArrayObject;
        $context->desc = '<p>Some text</p>';

        $view = new View(codecept_root_dir() . 'src/partials/section-description.phtml');

        $this->expectOutputString('<p>Some text</p>');
        $view->echo_kses($context);
    }

    /**
     * @covers ::render
     */
    public function testRenderUnreadableFile()
    {
        $view   = new View(codecept_root_dir() . '/not-exist.phtml');
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

        $view   = new View(codecept_root_dir() . 'src/partials/section-description.phtml');
        $actual = $view->render($context);

        $expected = '<p>Some text</p>';

        $this->assertSame($expected, $actual);
    }
}
