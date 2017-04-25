<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

use AspectMock\Test;
use Codeception\TestCase\WPTestCase;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\OptionStore
 * @covers \TypistTech\WPBetterSettings\OptionStore
 * @covers \TypistTech\WPBetterSettings\OptionStores\ConstantStrategy
 * @covers \TypistTech\WPBetterSettings\OptionStores\DatabaseStrategy
 * @covers \TypistTech\WPBetterSettings\OptionStores\FilterStrategy
 */
class OptionStoreTest extends WPTestCase
{
    /**
     * @var \AspectMock\Proxy\FuncProxy
     */
    private $applyFilters;

    /**
     * @var \TypistTech\WPBetterSettings\OptionStore
     */
    private $optionStore;

    public function testGet()
    {
        $actual = $this->optionStore->get('my_option');
        $this->assertSame('i live in wp_option', $actual);
    }

    public function testGetFromFilter()
    {
        $actual = $this->optionStore->get('my_option_filter');

        $this->assertSame('i am filtered', $actual);
        $this->applyFilters->verifyInvokedMultipleTimes(1);
        $this->applyFilters->verifyInvokedOnce([ 'my_option_filter', false ]);
    }

    public function testGetNonExistOption()
    {
        $actual = $this->optionStore->get('non_exist_option');
        $this->assertFalse($actual);
    }

    public function testGetStringFromConstant()
    {
        $actual = $this->optionStore->get('my_option_constant');
        $this->assertSame('i am a constant', $actual);
    }

    public function setUp()
    {
        parent::setUp();

        Test::func(__NAMESPACE__ . '\OptionStores', 'defined', function (string $name) {
            switch ($name) {
                case 'MY_OPTION_CONSTANT':
                    return true;
                default:
                    return false;
            }
        });

        Test::func(
            __NAMESPACE__ . '\OptionStores',
            'constant',
            function (string $name) {
                switch ($name) {
                    case 'MY_OPTION_CONSTANT':
                        return 'i am a constant';
                    default:
                        $this->fail($name . ' is not defined');
                }
            }
        );

        Test::func(__NAMESPACE__ . '\OptionStores', 'get_option', function (string $key) {
            switch ($key) {
                case 'my_option':
                    return 'i live in wp_option';
                default:
                    return false;
            }
        });

        $this->applyFilters = Test::func(
            __NAMESPACE__ . '\OptionStores',
            'apply_filters',
            function (string $tag, $value) {
                switch ($tag) {
                    case 'my_option_filter':
                        return 'i am filtered';
                    default:
                        return $value;
                }
            }
        );

        $this->optionStore = new OptionStore;
    }
}
