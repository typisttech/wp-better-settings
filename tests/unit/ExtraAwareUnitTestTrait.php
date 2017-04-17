<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

trait ExtraAwareUnitTestTrait
{
    abstract protected function getSubject();

    /**
     * @covers \TypistTech\WPBetterSettings\ExtraAwareTrait::setExtraElement
     * @covers \TypistTech\WPBetterSettings\ExtraAwareTrait::getExtra
     */
    public function testExtraSetterAndGetter()
    {
        $subject = $this->getSubject();
        $subject->setExtraElement('my-key', 'my value');

        $actual = $subject->getExtra();

        $this->assertArrayHasKey('my-key', $actual);
        $this->assertSame('my value', $actual['my-key']);
    }
}
