<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings\Views;

use Codeception\TestCase\WPTestCase;
use InvalidArgumentException;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\Views\ViewFactory
 */
class ViewFactoryTest extends WPTestCase
{
    /**
     * @covers ::build
     */
    public function testBuildViewFilename()
    {
        $actual = ViewFactory::build('section');
        $expected = new View(codecept_root_dir() . 'src/partials/section.php');
        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers ::build
     */
    public function testBuildViewObject()
    {
        $actual = ViewFactory::build('section');
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
