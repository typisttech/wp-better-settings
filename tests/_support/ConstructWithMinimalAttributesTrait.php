<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

trait ConstructWithMinimalAttributesTrait
{
    abstract public function minimalAttributesProvider(): array;

    abstract protected function getMinimalSubject();

    /**
     * @covers ::__construct
     * @dataProvider minimalAttributesProvider
     *
     * @param string $actualAttributeName Attribute to be tested.
     * @param mixed  $expected            Expected attribute.
     */
    public function testConstructWithMinimalAttributes(string $actualAttributeName, $expected)
    {
        $this->assertAttributeSame($expected, $actualAttributeName, $this->getMinimalSubject());
    }
}
