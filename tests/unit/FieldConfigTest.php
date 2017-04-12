<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\FieldConfig
 */
class FieldConfigTest extends \Codeception\Test\Unit
{
    /**
     * @covers ::__construct
     */
    public function testDefaultSanitizeCallback()
    {
        $config = new FieldConfig;
        $this->assertAttributeEquals('sanitize_text_field', 'sanitize_callback', $config);
    }

    /**
     * @coversNothing
     */
    public function testIsAnInstanceOfConfig()
    {
        $config = new FieldConfig;
        $this->assertInstanceOf(Config::class, $config);
    }
}
