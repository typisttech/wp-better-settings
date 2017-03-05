<?php
namespace WP_Better_Settings;

/**
 * @coversDefaultClass \WPBS\Option_Store
 */
class Option_Store_Test extends \Codeception\Test\Unit
{

    /**
     * @var \WPBS\Option_Store
     */
    private $optionStore;

    /**
     * @covers ::get
     */
    public function testGet()
    {
        $actual = $this->optionStore->get('my_option_array', 'my_text');
        $this->assertSame('long long text.', $actual);
    }

    /**
     * @covers ::get
     */
    public function testGetCheckbox()
    {
        $actual = $this->optionStore->get('my_option_array', 'my_checkbox');
        $this->assertSame('1', $actual);
    }

    /**
     * @covers ::get
     */
    public function testGetNonExistKey()
    {
        $actual = $this->optionStore->get('my_option_array', 'non_exist_key');
        $this->assertFalse($actual);
    }

    /**
     * @covers ::get
     */
    public function testGetNonExistOption()
    {
        $actual = $this->optionStore->get('non_exist_option', 'my_text');
        $this->assertFalse($actual);
    }

    /**
     * @covers ::get
     */
    public function testGetNonArray()
    {
        $actual = $this->optionStore->get('my_option_string', 'my_text');
        $this->assertSame('i live in wp_option', $actual);
    }

    protected function setUp()
    {
        parent::setUp();

        $optionArray  = [
            'my_text'     => 'long long text.',
            'my_checkbox' => '1',
        ];
        $optionString = 'i live in wp_option';
        update_option('my_option_array', $optionArray);
        update_option('my_option_string', $optionString);

        $this->optionStore = new Option_Store;
    }

    protected function tearDown()
    {
        delete_option('my_option_array');
        delete_option('my_option_string');

        parent::tearDown();
    }
}
