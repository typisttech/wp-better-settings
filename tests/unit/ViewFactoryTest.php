<?php

namespace TypistTech\WPBetterSettings;

use InvalidArgumentException;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\ViewFactory
 */
class ViewFactoryTest extends \Codeception\Test\Unit
{

    /**
     * @covers ::build
     */
    public function testBuildViewFilename()
    {
        $actual   = ViewFactory::build('section-description');
        $expected = new View(codecept_root_dir() . 'src/partials/section-description.php');
        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers ::build
     */
    public function testBuildViewObject()
    {
        $actual = ViewFactory::build('text-field');
        $this->assertInstanceOf(View::class, $actual);
    }

    /**
     * @covers ::build
     */
    public function testThrowInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        ViewFactory::build('something');
    }
}
