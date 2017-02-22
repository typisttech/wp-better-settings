<?php
namespace WPBS\WP_Better_Settings;

/**
 * @coversDefaultClass \WPBS\WP_Better_Settings\Option_Helper
 */
class Option_HelperTest extends \Codeception\Test\Unit
{
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
        $actual = $this->option_helper->get('my_option', 'my_text');
        $this->assertSame('long long text.', $actual);
    }

    /**
     * @covers ::get
     */
    public function testGetCheckbox()
    {
        $actual = $this->option_helper->get('my_option', 'my_checkbox');
        $this->assertSame('1', $actual);
    }

    /**
     * @covers ::get
     */
    public function testGetNonExistKey()
    {
        $actual = $this->option_helper->get('my_option', 'non_exist_key');
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

    protected function _after()
    {
        delete_option('my_option');
    }

    protected function _before()
    {
        $option = [
            'my_text'     => 'long long text.',
            'my_checkbox' => '1',
        ];
        update_option('my_option', $option);

        $this->option_helper = new Option_Helper;
    }
}
