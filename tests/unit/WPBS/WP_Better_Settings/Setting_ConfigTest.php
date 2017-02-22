<?php
namespace WPBS\WP_Better_Settings;

use UnexpectedValueException;

/**
 * @coversDefaultClass \WPBS\WP_Better_Settings\Setting_Config
 */
class Setting_ConfigTest extends \Codeception\TestCase\WPTestCase
{
    /**
     * @var Field_Config
     */
    private $field_1_1;

    /**
     * @var Field_Config
     */
    private $field_1_2;

    /**
     * @var Field_Config
     */
    private $field_2_1;

    /**
     * @var Field_Config
     */
    private $field_2_2;

    /**
     * @var Section_Config
     */
    private $section_1;

    /**
     * @var Section_Config
     */
    private $section_2;

    /**
     * @var Setting_Config
     */
    private $setting_config;

    public function setUp()
    {
        // before
        parent::setUp();

        $this->field_1_1      = new Field_Config([ 'id' => 'my_field_1_1' ]);
        $this->field_1_2      = new Field_Config([ 'id' => 'my_field_1_2' ]);
        $this->field_2_1      = new Field_Config([ 'id' => 'my_field_2_1' ]);
        $this->field_2_2      = new Field_Config([ 'id' => 'my_field_2_2' ]);
        $this->section_2      = new Section_Config([
            'id'     => 'my_section_2',
            'fields' => [
                $this->field_2_1,
                $this->field_2_2,
            ],
        ]);
        $this->section_1      = new Section_Config([
            'id'     => 'my_section_1',
            'fields' => [
                $this->field_1_1,
                $this->field_1_2,
            ],
        ]);
        $this->setting_config = new Setting_Config([
            'option_group' => 'my_option_group',
            'option_name'  => 'my_option_name',
            'sections'     => [
                $this->section_1,
                $this->section_2,
            ],
        ]);
    }

    /**
     * @coversNothing
     */
    public function testIsAnInstanceOfConfig()
    {
        $config = new Setting_Config();
        $this->assertInstanceOf(Config::class, $config);
    }

    /**
     * @covers ::get_fields
     */
    public function testGetFields()
    {
        $actual   = $this->setting_config->get_fields();
        $expected = [
            $this->field_1_1,
            $this->field_1_2,
            $this->field_2_1,
            $this->field_2_2,
        ];
        $this->assertSame($expected, $actual);
    }

    /**
     * @covers ::get_fields
     */
    public function testGetFieldsFlattenToFieldLevel()
    {
        $multi_dimensional_field = new Field_Config([
            'id'   => 'my_field_2_3',
            'some' => [ 'multi' => [ 'dimensional' => [ 'array' ] ] ],
        ]);
        $section_2               = new Section_Config([
            'id'     => 'my_section_2',
            'fields' => [
                $this->field_2_1,
                $this->field_2_2,
                $multi_dimensional_field,
            ],
        ]);
        $setting_config          = new Setting_Config([
            'sections' => [
                $this->section_1,
                $section_2,
            ],
        ]);

        $actual   = $setting_config->get_fields();
        $expected = [
            $this->field_1_1,
            $this->field_1_2,
            $this->field_2_1,
            $this->field_2_2,
            $multi_dimensional_field,
        ];
        $this->assertSame($expected, $actual);
    }

    /**
     * @covers ::get_sections
     */
    public function testGetSections()
    {
        $actual   = $this->setting_config->get_sections();
        $expected = [ $this->section_1, $this->section_2 ];
        $this->assertSame($expected, $actual);
    }

    /**
     * @covers ::get_sections
     */
    public function testThrowNotArrayException()
    {
        $setting_config = new Setting_Config([
            'sections' => 'not an array',
        ]);
        $this->expectException(UnexpectedValueException::class);
        $setting_config->get_sections();
    }

    /**
     * @covers ::get_sections
     */
    public function testThrowNotSectionConfigException()
    {
        $setting_config = new Setting_Config([
            'sections' => [ $this->section_1, 'not Section_Config' ],
        ]);
        $this->expectException(UnexpectedValueException::class);
        $setting_config->get_sections();
    }
}
