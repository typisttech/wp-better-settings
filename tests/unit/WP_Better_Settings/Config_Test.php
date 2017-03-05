<?php
namespace WP_Better_Settings;

use ArrayObject;

/**
 * @coversDefaultClass \WPBS\Config
 */
class Config_Test extends \Codeception\Test\Unit
{
    /**
     * @coversNothing
     */
    public function testIsAnInstanceOfArrayObject()
    {
        $config = new Config;
        $this->assertInstanceOf(ArrayObject::class, $config);
    }

    /**
     * @covers ::__construct
     */
    public function testTurnArrayEntriesIntoProperties()
    {
        $config = new Config([ 'a' => 'abc', 'z' => 'xyz' ]);
        $this->assertAttributeEquals('abc', 'a', $config);
        $this->assertAttributeEquals('xyz', 'z', $config);
    }

    /**
     * @covers ::has_key
     */
    public function testHasKey()
    {
        $config = new Config([ 'a' => 'abc', 'z' => 'xyz' ]);
        $this->assertTrue($config->has_key('a'));
        $this->assertFalse($config->has_key('b'));
    }

    /**
     * @covers ::get_key
     */
    public function testGetKey()
    {
        $config = new Config([ 'a' => 'abc', 'z' => 'xyz' ]);

        $this->assertSame('abc', $config->get_key('a'));
        $this->assertNull($config->get_key('b'));
    }

    /**
     * @covers ::get_keys
     */
    public function testGetKeys()
    {
        $config   = new Config([ 'a' => 'abc', 'z' => 'xyz' ]);
        $expected = [ 'a', 'z' ];
        $this->assertSame($expected, $config->get_keys());
    }

    /**
     * @covers ::get_keys
     */
    public function testGetKeysSingleElement()
    {
        $config   = new Config([ 'a' => 'abc' ]);
        $expected = [ 'a' ];
        $this->assertSame($expected, $config->get_keys());
    }

    /**
     * @covers ::get_keys
     */
    public function testGetKeysEmpty()
    {
        $config   = new Config();
        $expected = [];
        $this->assertSame($expected, $config->get_keys());
    }
}
