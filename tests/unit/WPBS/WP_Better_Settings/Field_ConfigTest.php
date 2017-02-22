<?php
namespace WPBS\WP_Better_Settings;

/**
 * @coversDefaultClass \WPBS\WP_Better_Settings\Field_Config
 */
class Field_ConfigTest extends \Codeception\TestCase\WPTestCase
{
    /**
     * @coversNothing
     */
    public function testIsAnInstanceOfConfig()
    {
        $config = new Field_Config();
        $this->assertInstanceOf(Config::class, $config);
    }
}
