<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

use AspectMock\Test;
use Codeception\Test\Unit;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\OptionStore
 */
class OptionStoreTest extends Unit
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
    public function testGet()
    {
        $actual = $this->optionStore->get('my_option');
        $this->assertSame('i live in wp_option', $actual);
    }

    /**
     * @covers \TypistTech\WPBetterSettings\OptionStore
     */
    public function testGetFromFilter()
    {
        $actual = $this->optionStore->get('my_option_filter');

        $this->assertSame('i am filtered', $actual);
        $this->applyFilters->verifyInvokedMultipleTimes(1);
        $this->applyFilters->verifyInvokedOnce([ 'my_option_filter', false ]);
    }

    /**
     * @covers \TypistTech\WPBetterSettings\OptionStore
     */
    public function testGetNonExistOption()
    {
        $actual = $this->optionStore->get('non_exist_option');
        $this->assertFalse($actual);
    }

    /**
     * @covers \TypistTech\WPBetterSettings\OptionStore
     */
    public function testGetStringFromConstant()
    {
        $actual = $this->optionStore->get('my_option_constant');
        $this->assertSame('i am a constant', $actual);
    }

    protected function _before()
    {
        Test::func(__NAMESPACE__, 'defined', function (string $name) {
            switch ($name) {
                case 'MY_OPTION_CONSTANT':
                    return true;
                default:
                    return false;
            }
        });

        Test::func(__NAMESPACE__, 'constant', function (string $name) {
            switch ($name) {
                case 'MY_OPTION_CONSTANT':
                    return 'i am a constant';
                default:
                    $this->fail($name . ' is not defined');
            }
        });

        Test::func(__NAMESPACE__, 'get_option', function (string $key) {
            switch ($key) {
                case 'my_option':
                    return 'i live in wp_option';
            }

            return false;
        });

        $this->applyFilters = Test::func(__NAMESPACE__, 'apply_filters', function (string $tag, $value) {
            switch ($tag) {
                case 'my_option_filter':
                    return 'i am filtered';
                default:
                    return $value;
            }
        });

        $this->optionStore = new OptionStore;
    }
}
