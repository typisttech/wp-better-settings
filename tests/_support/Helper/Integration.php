<?php

namespace TypistTech\WPBetterSettings\Helper;

use AspectMock\Test;
use Codeception\TestInterface;

/**
 * Here you can define custom actions
 * All public methods declared in helper class will be available in $I
 */
class Integration extends \Codeception\Module
{
    public function _after(TestInterface $test)
    {
        Test::clean();
    }
}
