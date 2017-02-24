<?php
namespace WPBS\WP_Better_Settings;

use Mockery;
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


    /**
     * @covers ::call_field_sanitize_fun
     */
    public function testCallFieldSanitizeFunUnsetEmptyInputs()
    {
        $input = [
            'field-false'        => false,
            'field-empty-array'  => [],
            'field-empty-string' => '',
            'field-null'         => null,
            'field-one'          => '1',
            'field-something'    => 'something',
            'field-zero'         => 0,
            'field-zero-string'  => '0',
        ];

        $expected = [
            'field-one'       => '1',
            'field-something' => 'something',
        ];

        $actual = $this->setting_config->call_field_sanitize_fun($input);
        $this->assertSame($expected, $actual);
    }

    /**
     * @covers ::call_field_sanitize_fun
     */
    public function testFieldSanitizeCallbackIsCalled()
    {
        $callback_mock = Mockery::mock('alias:\Test_Sanitizer');
        $callback_mock->shouldReceive('to_safe')
                      ->once()
                      ->with('dangerous', 'sanitizable_field')
                      ->andReturn('safe');

        $sanitizable_field = new Field_Config([
            'id'                => 'sanitizable_field',
            'sanitize_callback' => [ '\Test_Sanitizer', 'to_safe' ],
        ]);

        $section        = new Section_Config([
            'id'     => 'my_section',
            'fields' => [
                $this->field_2_1,
                $sanitizable_field,
            ],
        ]);
        $setting_config = new Setting_Config([
            'sections' => [
                $this->section_1,
                $section,
            ],
        ]);

        $actual   = $setting_config->call_field_sanitize_fun([ 'sanitizable_field' => 'dangerous' ]);
        $expected = [ 'sanitizable_field' => 'safe' ];
        $this->assertSame($expected, $actual);
    }
}
