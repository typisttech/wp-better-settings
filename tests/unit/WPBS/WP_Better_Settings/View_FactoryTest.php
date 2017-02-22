<?php
namespace WPBS\WP_Better_Settings;

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
    public function testBuildViewObjectFilename()
    {
        $actual = View_Factory::build('text-field');

        /**
         * Because Travis CI run this test in $TRAVIS_BUILD_DIR
         * But, WPLoader run the real plugin on /tmp/wordpress
         */
        $this->assertStringEndsWith(
            '/wp-better-settings/src/wp-better-settings/partials/text-field.phtml',
            $actual->get_filename()
        );
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
