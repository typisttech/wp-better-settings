<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

trait AttributeGetterTrait
{
    abstract protected function attributeGetterProvider(): array;

    abstract protected function getSubject();

    /**
     * @covers       ::<public>
     * @dataProvider attributeGetterProvider
     *
     * @param string $getterName Getter function to be tested.
     * @param mixed  $expected   Expected attribute.
     */
    public function testAttributeGetter(string $getterName, $expected)
    {
        $actual = $this->getSubject()->{$getterName}();

        $this->assertSame($expected, $actual);
    }
}
