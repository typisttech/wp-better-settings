<?php
namespace WPBS\WP_Better_Settings;

use InvalidArgumentException;

/**
 * @coversDefaultClass \WPBS\WP_Better_Settings\View_Factory
 */
class ViewFactoryTest extends \Codeception\Test\Unit
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
    public function testBuildViewFilename()
    {
        $actual   = View_Factory::build('section-description');
        $expected = new View(codecept_root_dir() . 'src/wp-better-settings/partials/section-description.phtml');
        $this->assertEquals($expected, $actual);
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
