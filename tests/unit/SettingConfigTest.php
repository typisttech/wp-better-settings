<?php

namespace TypistTech\WPBetterSettings;

use AspectMock\Test;
use UnexpectedValueException;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\SettingConfig
 */
class SettingConfigTest extends \Codeception\Test\Unit
{
    /**
     * @var FieldConfig
     */
    private $field11;

    /**
     * @var FieldConfig
     */
    private $field12;

    /**
     * @var FieldConfig
     */
    private $field21;

    /**
     * @var FieldConfig
     */
    private $field22;

    /**
     * @var SectionConfig
     */
    private $section1;

    /**
     * @var SectionConfig
     */
    private $section2;

    /**
     * @var SettingConfig
     */
    private $settingConfig;

    /**
     * @covers ::callFieldSanitizeFun
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

        $actual = $this->settingConfig->callFieldSanitizeFun($input);
        $this->assertSame($expected, $actual);
    }

    /**
     * @covers ::callFieldSanitizeFun
     */
    public function testFieldSanitizeCallbackIsCalled()
    {
        $sanitizer = Test::double(Sanitizer::class, [
            'sanitizeEmail' => 'safe',
        ]);

        $sanitizableField = new FieldConfig([
            'id'                => 'sanitizable_field',
            'sanitize_callback' => [ Sanitizer::class, 'sanitizeEmail' ],
        ]);

        $section       = new SectionConfig([
            'id'     => 'my_section',
            'fields' => [
                $this->field21,
                $sanitizableField,
            ],
        ]);
        $settingConfig = new SettingConfig([
            'sections' => [
                $this->section1,
                $section,
            ],
        ]);

        $actual   = $settingConfig->callFieldSanitizeFun([
            'sanitizable_field' => 'dangerous',
        ]);
        $expected = [
            'sanitizable_field' => 'safe',
        ];

        $this->assertSame($expected, $actual);
        $sanitizer->verifyInvokedMultipleTimes('sanitizeEmail', 1);
        $sanitizer->verifyInvokedOnce('sanitizeEmail', [ 'dangerous', 'sanitizable_field' ]);
    }

    /**
     * @covers ::getFields
     */
    public function testGetFields()
    {
        $actual   = $this->settingConfig->getFields();
        $expected = [
            $this->field11,
            $this->field12,
            $this->field21,
            $this->field22,
        ];
        $this->assertSame($expected, $actual);
    }

    /**
     * @covers ::getFields
     */
    public function testGetFieldsFlattenToFieldLevel()
    {
        $multidimensionalField = new FieldConfig([
            'id'   => 'my_field_2_3',
            'some' => [
                'multi' => [
                    'dimensional' => [
                        'array',
                    ],
                ],
            ],
        ]);
        $section2              = new SectionConfig([
            'id'     => 'my_section_2',
            'fields' => [
                $this->field21,
                $this->field22,
                $multidimensionalField,
            ],
        ]);
        $settingConfig         = new SettingConfig([
            'sections' => [
                $this->section1,
                $section2,
            ],
        ]);

        $actual   = $settingConfig->getFields();
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
     * @covers ::getSections
     */
    public function testGetSections()
    {
        $actual   = $this->settingConfig->getSections();
        $expected = [ $this->section1, $this->section2 ];
        $this->assertSame($expected, $actual);
    }

    /**
     * @coversNothing
     */
    public function testIsAnInstanceOfConfig()
    {
        $config = new SettingConfig;
        $this->assertInstanceOf(Config::class, $config);
    }

    /**
     * @covers ::getSections
     */
    public function testThrowNotArrayException()
    {
        $settingConfig = new SettingConfig([
            'sections' => 'not an array',
        ]);
        $this->expectException(UnexpectedValueException::class);
        $settingConfig->getSections();
    }

    /**
     * @covers ::getSections
     */
    public function testThrowNotSectionConfigException()
    {
        $settingConfig = new SettingConfig([
            'sections' => [ $this->section1, 'not Section_Config' ],
        ]);
        $this->expectException(UnexpectedValueException::class);
        $settingConfig->getSections();
    }

    protected function _before()
    {
        $this->field11       = new FieldConfig([
            'id' => 'my_field_1_1',
        ]);
        $this->field12       = new FieldConfig(
            [
                'id' => 'my_field_1_2',
            ]
        );
        $this->field21       = new FieldConfig([
            'id' => 'my_field_2_1',
        ]);
        $this->field22       = new FieldConfig(
            [
                'id' => 'my_field_2_2',
            ]
        );
        $this->section2      = new SectionConfig([
            'id'     => 'my_section_2',
            'fields' => [
                $this->field21,
                $this->field22,
            ],
        ]);
        $this->section1      = new SectionConfig([
            'id'     => 'my_section_1',
            'fields' => [
                $this->field11,
                $this->field12,
            ],
        ]);
        $this->settingConfig = new SettingConfig([
            'option_group' => 'my_option_group',
            'option_name'  => 'my_option_name',
            'sections'     => [
                $this->section1,
                $this->section2,
            ],
        ]);
    }
}
