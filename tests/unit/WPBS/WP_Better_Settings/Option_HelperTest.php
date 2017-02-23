<?php
namespace WPBS\WP_Better_Settings;

use phpmock\phpunit\PHPMock;

/**
 * @coversDefaultClass \WPBS\WP_Better_Settings\Option_Helper
 */
class Option_HelperTest extends \Codeception\Test\Unit
{
    use PHPMock;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \WPBS\WP_Better_Settings\Option_Helper
     */
    private $option_helper;

    /**
     * @covers ::get
     */
    public function testGet()
    {
        $actual = $this->option_helper->get('my_option_array', 'my_text');
        $this->assertSame('long long text.', $actual);
    }

    /**
     * @covers ::get
     */
    public function testGetCheckbox()
    {
        $actual = $this->option_helper->get('my_option_array', 'my_checkbox');
        $this->assertSame('1', $actual);
    }

    /**
     * @covers ::get
     */
    public function testGetNonExistKey()
    {
        $actual = $this->option_helper->get('my_option_array', 'non_exist_key');
        $this->assertFalse($actual);
    }

    /**
     * @covers ::get
     */
    public function testGetNonExistOption()
    {
        $actual = $this->option_helper->get('non_exist_option', 'my_text');
        $this->assertFalse($actual);
    }

    /**
     * @covers ::get
     */
    public function testGetNonArray()
    {
        $actual = $this->option_helper->get('my_option_string', 'my_text');
        $this->assertSame('i live in wp_option', $actual);
    }

    protected function _before()
    {
        $option_array = [
            'my_text'     => 'long long text.',
            'my_checkbox' => '1',
        ];

        $option_string = 'i live in wp_option';

        $add_settings_error = $this->getFunctionMock(__NAMESPACE__, 'get_option');
        $add_settings_error->expects($this->any())
                           ->willReturnCallback(
                               function ($option_key) use ($option_array, $option_string) {
                                    switch ($option_key) {
                                        case 'my_option_array':
                                            return $option_array;
                                        case 'my_option_string':
                                            return $option_string;
                                        default:
                                            return false;
                                    }
                                 }
                           );

        $this->option_helper = new Option_Helper;
    }
}
