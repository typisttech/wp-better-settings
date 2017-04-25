<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings\Factories;

use Codeception\TestCase\WPTestCase;
use InvalidArgumentException;
use TypistTech\WPBetterSettings\Views\View;

/**
 * @covers \TypistTech\WPBetterSettings\Factories\ViewFactory
 */
class ViewFactoryTest extends WPTestCase
{
    public function testBuildViewFilename()
    {
        $actual = ViewFactory::build('section');
        $expected = new View(codecept_root_dir() . 'src/partials/section.php');
        $this->assertEquals($expected, $actual);
    }

    public function testBuildViewObject()
    {
        $actual = ViewFactory::build('section');
        $this->assertInstanceOf(View::class, $actual);
    }

    public function testThrowInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        ViewFactory::build('something');
    }
}
