<?php
namespace WPBS\WP_Better_Settings;

/**
 * @coversDefaultClass \WPBS\WP_Better_Settings\SettingConfig
 */
class SettingConfigTest extends \Codeception\TestCase\WPTestCase
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
     * @var SettingConfig
     */
    private $setting_config;

    public function setUp()
    {
        // before
        parent::setUp();

        $this->field_1_1      = new Field_Config([
            'id'      => 'my_field_1_1',
            'default' => 'my_default_1_1',
        ]);
        $this->field_1_2      = new Field_Config([ 'id' => 'my_field_1_2' ]);
        $this->field_2_1      = new Field_Config([ 'id' => 'my_field_2_1' ]);
        $this->field_2_2      = new Field_Config([
            'id'      => 'my_field_2_2',
            'default' => 'my_default_2_2',
        ]);
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
        $this->setting_config = new SettingConfig([
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
        $config = new SettingConfig();
        $this->assertInstanceOf(Config::class, $config);
    }

    /**
     * @covers ::get_field
     */
    public function testGetField()
    {
        $actual = $this->setting_config->get_field('my_field_2_1');
        $this->assertSame($this->field_2_1, $actual);
    }

    /**
     * @covers ::get_field
     */
    public function testGetNotExistField()
    {
        $actual = $this->setting_config->get_field('not_exist_field');
        $this->assertNull($actual);
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
    public function testGetFieldsWithoutSections()
    {
        $setting_config = new SettingConfig;
        $actual         = $setting_config->get_fields();
        $this->assertSame([], $actual);
    }

    /**
     * @covers ::get_fields
     */
    public function testGetFieldsWithoutFields()
    {
        $setting_config = new SettingConfig([ 'sections' => [] ]);
        $actual         = $setting_config->get_fields();
        $this->assertSame([], $actual);
    }

    /**
     * @covers ::default_option
     */
    public function testDefaultOption()
    {
        $actual   = $this->setting_config->default_option();
        $expected = [
            'my_field_1_1' => 'my_default_1_1',
            'my_field_2_2' => 'my_default_2_2',
        ];
        $this->assertSame($expected, $actual);
    }

    /**
     * @covers ::default_option
     */
    public function testDefaultOptionNoDefaults()
    {
        $setting_config = new SettingConfig([
            'sections' => [
                new Section_Config([
                    'id'     => 'my_section_2',
                    'fields' => [
                        $this->field_1_2,
                        $this->field_2_1,
                    ],
                ]),
            ],
        ]);
        $actual         = $setting_config->default_option();
        $this->assertSame([], $actual);
    }

    /**
     * @covers ::default_option
     */
    public function testDefaultOptionEmptyFields()
    {
        $setting_config = new SettingConfig;
        $actual         = $setting_config->default_option();
        $this->assertSame([], $actual);
    }
}
