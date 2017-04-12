<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

use ArrayObject;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\Config
 */
class ConfigTest extends \Codeception\Test\Unit
{
    /**
     * @covers ::getKey
     */
    public function testGetKey()
    {
        $config = new Config([
            'a' => 'abc',
            'z' => 'xyz',
        ]);

        $this->assertSame('abc', $config->getKey('a'));
        $this->assertNull($config->getKey('b'));
    }

    /**
     * @covers ::getKeys
     */
    public function testGetKeys()
    {
        $config   = new Config([
            'a' => 'abc',
            'z' => 'xyz',
        ]);
        $expected = [ 'a', 'z' ];
        $this->assertSame($expected, $config->getKeys());
    }

    /**
     * @covers ::getKeys
     */
    public function testGetKeysEmpty()
    {
        $config   = new Config;
        $expected = [];
        $this->assertSame($expected, $config->getKeys());
    }

    /**
     * @covers ::getKeys
     */
    public function testGetKeysSingleElement()
    {
        $config   = new Config([
            'a' => 'abc',
        ]);
        $expected = [ 'a' ];
        $this->assertSame($expected, $config->getKeys());
    }

    /**
     * @covers ::hasKey
     */
    public function testHasKey()
    {
        $config = new Config([
            'a' => 'abc',
            'z' => 'xyz',
        ]);
        $this->assertTrue($config->hasKey('a'));
        $this->assertFalse($config->hasKey('b'));
    }

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
        $config = new Config([
            'a' => 'abc',
            'z' => 'xyz',
        ]);
        $this->assertAttributeEquals('abc', 'a', $config);
        $this->assertAttributeEquals('xyz', 'z', $config);
    }
}
