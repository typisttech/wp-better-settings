<?php
namespace WPBS\WP_Better_Settings;

/**
 * @coversDefaultClass \WPBS\WP_Better_Settings\Option_Helper
 */
class Option_HelperTest extends \Codeception\Test\Unit
{

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

    protected function _after()
    {
        delete_option('my_option_array');
        delete_option('my_option_string');

        parent::_after();
    }

    protected function _before()
    {
        parent::_before();

        $option_array  = [
            'my_text'     => 'long long text.',
            'my_checkbox' => '1',
        ];
        $option_string = 'i live in wp_option';
        update_option('my_option_array', $option_array);
        update_option('my_option_string', $option_string);

        $this->option_helper = new Option_Helper;
    }
}
