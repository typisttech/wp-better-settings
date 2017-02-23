<?php
namespace WPBS\WP_Better_Settings;

use ArrayObject;

/**
 * @coversDefaultClass \WPBS\WP_Better_Settings\View_Factory
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

        $view = new View(codecept_root_dir() . 'src/wp-better-settings/partials/section-description.phtml');

        $this->expectOutputString('<p>Some text</p>');
        $view->echo_kses($context);
    }

    /**
     * @covers ::render
     */
    public function testRenderUnreadableFile()
    {
        $actual_view = new View(codecept_root_dir() . '/not-exist.phtml');
        $actual      = $actual_view->render(new ArrayObject);
        $this->assertSame('', $actual);
    }

    /**
     * @covers ::render
     */
    public function testRenderWithContext()
    {
        $context       = new ArrayObject;
        $context->desc = '<p>Some text</p>';

        $actual_view = new View(codecept_root_dir() . 'src/wp-better-settings/partials/section-description.phtml');
        $actual      = $actual_view->render($context);

        $expected = '<p>Some text</p>';

        $this->assertSame($expected, $actual);
    }
}
