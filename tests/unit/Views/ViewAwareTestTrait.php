<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings\Views;

use AspectMock\Test;

trait ViewAwareTestTrait
{
    /**
     * @covers \TypistTech\WPBetterSettings\Views\ViewAwareTrait::getCallbackFunction
     */
    public function testGetCallbackFunction()
    {
        $subject = $this->getSubject();

        $actual = $subject->getCallbackFunction();
        $expected = [ $subject, 'echoView' ];

        $this->assertSame($expected, $actual);
    }

    abstract protected function getSubject();

    /**
     * @covers \TypistTech\WPBetterSettings\Views\ViewAwareTrait::setView
     * @covers \TypistTech\WPBetterSettings\Views\ViewAwareTrait::echoView
     */
    public function testSetAndEchoView()
    {
        $viewDouble = Test::double(
            View::class,
            [
                'echoKses' => true,
            ]
        );

        $subject = $this->getSubject();

        $subject->setView($viewDouble->make());
        $subject->echoView();

        $viewDouble->verifyInvokedMultipleTimes('echoKses', 1);
        $viewDouble->verifyInvokedOnce('echoKses', [ $subject ]);
    }
}
