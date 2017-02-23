<?php
namespace WPBS\WP_Better_Settings;

use ArrayObject;
use InvalidArgumentException;

/**
 * @coversDefaultClass \WPBS\WP_Better_Settings\View_Factory
 */
class View_FactoryTest extends \Codeception\TestCase\WPTestCase
{

    /**
     * @covers ::build
     */
    public function testBuildViewObject()
    {
        $actual = View_Factory::build('text-field');
        $this->assertInstanceOf(View::class, $actual);
    }

    /**
     * @covers ::build
     */
    public function testBuildViewRender()
    {
        $context       = new ArrayObject;
        $context->desc = '<p>Some text</p>';

        $actual_view = View_Factory::build('section-description');
        $actual      = $actual_view->render($context);

        $expected = '<p>Some text</p>';

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers ::build
     */
    public function testThrowInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        View_Factory::build('something');
    }
}
