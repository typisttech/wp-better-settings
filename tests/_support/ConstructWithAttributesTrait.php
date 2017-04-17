<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

trait ConstructWithAttributesTrait
{
    abstract public function attributesProvider(): array;

    abstract protected function getSubject();

    /**
     * @covers ::__construct
     * @dataProvider attributesProvider
     *
     * @param string $actualAttributeName Attribute to be tested.
     * @param mixed  $expected            Expected attribute.
     */
    public function testConstructWithAttributes(string $actualAttributeName, $expected)
    {
        $this->assertAttributeSame($expected, $actualAttributeName, $this->getSubject());
    }
}
