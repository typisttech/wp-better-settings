<?php

namespace TypistTech\WPBetterSettings;

use UnexpectedValueException;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\SectionConfig
 */
class SectionConfigTest extends \Codeception\TestCase\WPTestCase
{
    /**
     * @var FieldConfig
     */
    private $fieldConfig1;

    /**
     * @var FieldConfig
     */
    private $fieldConfig2;

    /**
     * @var SectionConfig
     */
    private $sectionConfig;

    /**
     * @covers ::getFields
     */
    public function testGetFields()
    {
        $actual   = $this->sectionConfig->getFields();
        $expected = [ $this->fieldConfig1, $this->fieldConfig2 ];
        $this->assertSame($expected, $actual);
    }

    /**
     * @coversNothing
     */
    public function testIsAnInstanceOfConfig()
    {
        $this->assertInstanceOf(Config::class, $this->sectionConfig);
    }

    /**
     * @covers ::getFields
     */
    public function testThrowNotArrayException()
    {
        $sectionConfig = new SectionConfig([
            'fields' => 'not an array',
        ]);
        $this->expectException(UnexpectedValueException::class);
        $sectionConfig->getFields();
    }

    /**
     * @covers ::getFields
     */
    public function testThrowNotFieldConfigException()
    {
        $sectionConfig = new SectionConfig([
            'fields' => [ $this->fieldConfig1, 'not Field_Config' ],
        ]);
        $this->expectException(UnexpectedValueException::class);
        $sectionConfig->getFields();
    }

    protected function _before()
    {
        $this->fieldConfig1  = new FieldConfig([
            'id' => 'my_field_1',
        ]);
        $this->fieldConfig2  = new FieldConfig([
            'id' => 'my_field_2',
        ]);
        $this->sectionConfig = new SectionConfig([
            'id' => 'my_section',
            'fields' => [
                $this->fieldConfig1,
                $this->fieldConfig2,
            ],
        ]);
    }
}
