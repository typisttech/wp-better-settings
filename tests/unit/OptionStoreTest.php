<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

use AspectMock\Test;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\OptionStore
 */
class OptionStoreTest extends \Codeception\Test\Unit
{
    /**
     * @var \AspectMock\Proxy\FuncProxy
     */
    private $applyFilters;

    /**
     * @var \TypistTech\WPBetterSettings\OptionStore
     */
    private $optionStore;

    /**
     * @covers \TypistTech\WPBetterSettings\OptionStore
     */
    public function testGetArrayElementFromFilter()
    {
        $actual = $this->optionStore->get('my_option_array', 'my_text_filter');

        $this->assertSame('i am filtered text', $actual);
        $this->applyFilters->verifyInvokedMultipleTimes(1);
        $this->applyFilters->verifyInvokedOnce([ 'my_option_array_my_text_filter', false ]);
    }

    /**
     * @covers \TypistTech\WPBetterSettings\OptionStore
     */
    public function testGetCheckboxFromArray()
    {
        $actual = $this->optionStore->get('my_option_array', 'my_checkbox');
        $this->assertTrue($actual);
    }

    /**
     * @covers \TypistTech\WPBetterSettings\OptionStore
     */
    public function testGetCheckedCheckboxFromArrayConstant()
    {
        $actual = $this->optionStore->get('my_option_array', 'my_checked_checkbox_constant');
        $this->assertTrue($actual);
    }

    /**
     * @covers \TypistTech\WPBetterSettings\OptionStore
     */
    public function testGetFromFilter()
    {
        $actual = $this->optionStore->get('my_option_string_filter');

        $this->assertSame('i am filtered string', $actual);
        $this->applyFilters->verifyInvokedMultipleTimes(1);
        $this->applyFilters->verifyInvokedOnce([ 'my_option_string_filter', false ]);
    }

    /**
     * @covers \TypistTech\WPBetterSettings\OptionStore
     */
    public function testGetNonExistKeyFromArray()
    {
        $actual = $this->optionStore->get('my_option_array', 'non_exist_key');
        $this->assertFalse($actual);
    }

    /**
     * @covers \TypistTech\WPBetterSettings\OptionStore
     */
    public function testGetNonExistOption()
    {
        $actual = $this->optionStore->get('non_exist_option', 'my_text');
        $this->assertFalse($actual);
    }

    /**
     * @covers \TypistTech\WPBetterSettings\OptionStore
     */
    public function testGetString()
    {
        $actual = $this->optionStore->get('my_option_string');
        $this->assertSame('i live in wp_option', $actual);
    }

    /**
     * @covers \TypistTech\WPBetterSettings\OptionStore
     */
    public function testGetStringFromArray()
    {
        $actual = $this->optionStore->get('my_option_array', 'my_text');
        $this->assertSame('long long text.', $actual);
    }

    /**
     * @covers \TypistTech\WPBetterSettings\OptionStore
     */
    public function testGetStringFromArrayConstant()
    {
        $actual = $this->optionStore->get('my_option_array', 'my_text_constant');
        $this->assertSame('i am constant', $actual);
    }

    /**
     * @covers \TypistTech\WPBetterSettings\OptionStore
     */
    public function testGetStringFromConstant()
    {
        $actual = $this->optionStore->get('my_option_string_constant');
        $this->assertSame('i am string constant', $actual);
    }

    /**
     * @covers \TypistTech\WPBetterSettings\OptionStore
     */
    public function testGetUncheckedCheckboxFromArrayConstant()
    {
        $actual = $this->optionStore->get('my_option_array', 'my_unchecked_checkbox_constant');
        $this->assertFalse($actual);
    }

    protected function _before()
    {
        Test::func(__NAMESPACE__, 'defined', function (string $name) {
            switch ($name) {
                case 'MY_OPTION_STRING_CONSTANT':
                case 'MY_OPTION_ARRAY_MY_TEXT_CONSTANT':
                case 'MY_OPTION_ARRAY_MY_CHECKED_CHECKBOX_CONSTANT':
                case 'MY_OPTION_ARRAY_MY_UNCHECKED_CHECKBOX_CONSTANT':
                    return true;
            }

            return false;
        });

        Test::func(__NAMESPACE__, 'constant', function (string $name) {
            switch ($name) {
                case 'MY_OPTION_STRING_CONSTANT':
                    return 'i am string constant';
                case 'MY_OPTION_ARRAY_MY_TEXT_CONSTANT':
                    return 'i am constant';
                case 'MY_OPTION_ARRAY_MY_CHECKED_CHECKBOX_CONSTANT':
                    return true;
                case 'MY_OPTION_ARRAY_MY_UNCHECKED_CHECKBOX_CONSTANT':
                    return false;
            }

            $this->fail($name . ' is not defined');
        });

        Test::func(__NAMESPACE__, 'get_option', function (string $key) {
            switch ($key) {
                case 'my_option_array':
                    return [
                        'my_text'                        => 'long long text.',
                        'my_text_constant'               => 'i am not constant',
                        'my_checkbox'                    => true,
                        'my_unchecked_checkbox_constant' => true,
                    ];
                case 'my_option_string':
                    return 'i live in wp_option';
            }

            return false;
        });

        $this->applyFilters = Test::func(__NAMESPACE__, 'apply_filters', function (string $tag, $value) {
            switch ($tag) {
                case 'my_option_string_filter':
                    return 'i am filtered string';
                case 'my_option_array_my_text_filter':
                    return 'i am filtered text';
            }

            return $value;
        });

        $this->optionStore = new OptionStore;
    }
}
