<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

trait ConstructWithMinimalAttributesTrait
{
    abstract protected function getMinimalSubject();

    abstract protected function minimalAttributesProvider(): array;

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
