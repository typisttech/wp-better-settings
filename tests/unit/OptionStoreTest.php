<?php

namespace TypistTech\WPBetterSettings;

use AspectMock\Test;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\OptionStore
 */
class OptionStoreTest extends \Codeception\Test\Unit
{

    /**
     * @var \TypistTech\WPBetterSettings\OptionStore
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
    public function testGetNonArray()
    {
        $actual = $this->optionStore->get('my_option_string', 'my_text');
        $this->assertSame('i live in wp_option', $actual);
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

    protected function _before()
    {
        Test::func(__NAMESPACE__, 'get_option', function (string $key) {
            switch ($key) {
                case 'my_option_array':
                    return [
                        'my_text'     => 'long long text.',
                        'my_checkbox' => '1',
                    ];
                case 'my_option_string':
                    return 'i live in wp_option';
                default:
                    return false;
            }
        });

        $this->optionStore = new OptionStore;
    }
}
