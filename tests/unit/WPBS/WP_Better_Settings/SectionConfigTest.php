<?php
namespace WPBS\WP_Better_Settings;

use UnexpectedValueException;

/**
 * @coversDefaultClass \WPBS\WP_Better_Settings\Section_Config
 */
class Section_ConfigTest extends \Codeception\Test\Unit
{
    /**
     * @var Field_Config
     */
    private $field_config_1;

    /**
     * @var Field_Config
     */
    private $field_config_2;

    /**
     * @var Section_Config
     */
    private $section_config;

    public function setUp()
    {
        // before
        parent::setUp();

        $this->field_config_1 = new Field_Config([ 'id' => 'my_field_1' ]);
        $this->field_config_2 = new Field_Config([ 'id' => 'my_field_2' ]);
        $this->section_config = new Section_Config([
            'id'     => 'my_section',
            'fields' => [
                $this->field_config_1,
                $this->field_config_2,
            ],
        ]);
    }

    /**
     * @coversNothing
     */
    public function testIsAnInstanceOfConfig()
    {
        $this->assertInstanceOf(Config::class, $this->section_config);
    }

    /**
     * @covers ::get_fields
     */
    public function testGetFields()
    {
        $actual   = $this->section_config->get_fields();
        $expected = [ $this->field_config_1, $this->field_config_2 ];
        $this->assertSame($expected, $actual);
    }

    /**
     * @covers ::get_fields
     */
    public function testThrowNotArrayException()
    {
        $section_config = new Section_Config([
            'fields' => 'not an array',
        ]);
        $this->expectException(UnexpectedValueException::class);
        $section_config->get_fields();
    }

    /**
     * @covers ::get_fields
     */
    public function testThrowNotFieldConfigException()
    {
        $section_config = new Section_Config([
            'fields' => [ $this->field_config_1, 'not Field_Config' ],
        ]);
        $this->expectException(UnexpectedValueException::class);
        $section_config->get_fields();
    }
}
