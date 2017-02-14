<?php
namespace WPBS\WP_Better_Settings;

/**
 * @coversDefaultClass \WPBS\WP_Better_Settings\FieldConfig
 */
class FieldConfigTest extends \Codeception\TestCase\WPTestCase
{
    /**
     * @coversNothing
     */
    public function testIsAnInstanceOfConfig()
    {
        $config = new FieldConfig();
        $this->assertInstanceOf(Config::class, $config);
    }
}
