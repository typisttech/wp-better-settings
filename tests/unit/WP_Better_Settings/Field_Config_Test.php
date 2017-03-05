<?php
namespace WP_Better_Settings;

/**
 * @coversDefaultClass \WPBS\Field_Config
 */
class Field_Config_Test extends \Codeception\Test\Unit
{
    /**
     * @coversNothing
     */
    public function testIsAnInstanceOfConfig()
    {
        $config = new Field_Config;
        $this->assertInstanceOf(Config::class, $config);
    }

    /**
     * @covers ::__construct
     */
    public function testDefaultSanitizeCallback()
    {
        $config = new Field_Config;
        $this->assertAttributeEquals('sanitize_text_field', 'sanitize_callback', $config);
    }
}
