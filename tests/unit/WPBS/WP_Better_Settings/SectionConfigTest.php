<?php
namespace WPBS\WP_Better_Settings;

use UnexpectedValueException;

/**
 * @coversDefaultClass \WPBS\WP_Better_Settings\Section_Config
 */
class SectionConfigTest extends \Codeception\Test\Unit
{
    /**
     * @var Field_Config
     */
    private $fieldConfig1;

    /**
     * @var Field_Config
     */
    private $fieldConfig2;

    /**
     * @var Section_Config
     */
    private $sectionConfig;

    /**
     * @coversNothing
     */
    public function testIsAnInstanceOfConfig()
    {
        $this->assertInstanceOf(Config::class, $this->sectionConfig);
    }

    /**
     * @covers ::get_fields
     */
    public function testGetFields()
    {
        $actual   = $this->sectionConfig->get_fields();
        $expected = [ $this->fieldConfig1, $this->fieldConfig2 ];
        $this->assertSame($expected, $actual);
    }

    /**
     * @covers ::get_fields
     */
    public function testThrowNotArrayException()
    {
        $sectionConfig = new Section_Config([
            'fields' => 'not an array',
        ]);
        $this->expectException(UnexpectedValueException::class);
        $sectionConfig->get_fields();
    }

    /**
     * @covers ::get_fields
     */
    public function testThrowNotFieldConfigException()
    {
        $sectionConfig = new Section_Config([
            'fields' => [ $this->fieldConfig1, 'not Field_Config' ],
        ]);
        $this->expectException(UnexpectedValueException::class);
        $sectionConfig->get_fields();
    }

    protected function setUp()
    {
        // before
        parent::setUp();

        $this->fieldConfig1  = new Field_Config([ 'id' => 'my_field_1' ]);
        $this->fieldConfig2  = new Field_Config([ 'id' => 'my_field_2' ]);
        $this->sectionConfig = new Section_Config([
            'id'     => 'my_section',
            'fields' => [
                $this->fieldConfig1,
                $this->fieldConfig2,
            ],
        ]);
    }
}
