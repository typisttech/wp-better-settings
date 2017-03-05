<?php
namespace WP_Better_Settings;

use Mockery;
use UnexpectedValueException;

/**
 * @coversDefaultClass \WPBS\Setting_Config
 */
class Setting_Config_Test extends \Codeception\Test\Unit
{
    /**
     * @var Field_Config
     */
    private $field11;

    /**
     * @var Field_Config
     */
    private $field12;

    /**
     * @var Field_Config
     */
    private $field21;

    /**
     * @var Field_Config
     */
    private $field22;

    /**
     * @var Section_Config
     */
    private $section1;

    /**
     * @var Section_Config
     */
    private $section2;

    /**
     * @var Setting_Config
     */
    private $settingConfig;

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
        $actual   = $this->settingConfig->get_fields();
        $expected = [
            $this->field11,
            $this->field12,
            $this->field21,
            $this->field22,
        ];
        $this->assertSame($expected, $actual);
    }

    /**
     * @covers ::get_fields
     */
    public function testGetFieldsFlattenToFieldLevel()
    {
        $multidimensionalField = new Field_Config([
            'id'   => 'my_field_2_3',
            'some' => [ 'multi' => [ 'dimensional' => [ 'array' ] ] ],
        ]);
        $section2              = new Section_Config([
            'id'     => 'my_section_2',
            'fields' => [
                $this->field21,
                $this->field22,
                $multidimensionalField,
            ],
        ]);
        $settingConfig         = new Setting_Config([
            'sections' => [
                $this->section1,
                $section2,
            ],
        ]);

        $actual   = $settingConfig->get_fields();
        $expected = [
            $this->field11,
            $this->field12,
            $this->field21,
            $this->field22,
            $multidimensionalField,
        ];
        $this->assertSame($expected, $actual);
    }

    /**
     * @covers ::get_sections
     */
    public function testGetSections()
    {
        $actual   = $this->settingConfig->get_sections();
        $expected = [ $this->section1, $this->section2 ];
        $this->assertSame($expected, $actual);
    }

    /**
     * @covers ::get_sections
     */
    public function testThrowNotArrayException()
    {
        $settingConfig = new Setting_Config([
            'sections' => 'not an array',
        ]);
        $this->expectException(UnexpectedValueException::class);
        $settingConfig->get_sections();
    }

    /**
     * @covers ::get_sections
     */
    public function testThrowNotSectionConfigException()
    {
        $settingConfig = new Setting_Config([
            'sections' => [ $this->section1, 'not Section_Config' ],
        ]);
        $this->expectException(UnexpectedValueException::class);
        $settingConfig->get_sections();
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

        $actual = $this->settingConfig->call_field_sanitize_fun($input);
        $this->assertSame($expected, $actual);
    }

    /**
     * @covers ::call_field_sanitize_fun
     */
    public function testFieldSanitizeCallbackIsCalled()
    {
        $callbackMock = Mockery::mock('alias:\Test_Sanitizer');
        $callbackMock->shouldReceive('to_safe')
                     ->once()
                     ->with('dangerous', 'sanitizable_field')
                     ->andReturn('safe');

        $sanitizableField = new Field_Config([
            'id'                => 'sanitizable_field',
            'sanitize_callback' => [ '\Test_Sanitizer', 'to_safe' ],
        ]);

        $section       = new Section_Config([
            'id'     => 'my_section',
            'fields' => [
                $this->field21,
                $sanitizableField,
            ],
        ]);
        $settingConfig = new Setting_Config([
            'sections' => [
                $this->section1,
                $section,
            ],
        ]);

        $actual   = $settingConfig->call_field_sanitize_fun([ 'sanitizable_field' => 'dangerous' ]);
        $expected = [ 'sanitizable_field' => 'safe' ];
        $this->assertSame($expected, $actual);
    }

    protected function setUp()
    {
        // before
        parent::setUp();

        $this->field11       = new Field_Config([ 'id' => 'my_field_1_1' ]);
        $this->field12       = new Field_Config([ 'id' => 'my_field_1_2' ]);
        $this->field21       = new Field_Config([ 'id' => 'my_field_2_1' ]);
        $this->field22       = new Field_Config([ 'id' => 'my_field_2_2' ]);
        $this->section2      = new Section_Config([
            'id'     => 'my_section_2',
            'fields' => [
                $this->field21,
                $this->field22,
            ],
        ]);
        $this->section1      = new Section_Config([
            'id'     => 'my_section_1',
            'fields' => [
                $this->field11,
                $this->field12,
            ],
        ]);
        $this->settingConfig = new Setting_Config([
            'option_group' => 'my_option_group',
            'option_name'  => 'my_option_name',
            'sections'     => [
                $this->section1,
                $this->section2,
            ],
        ]);
    }
}
