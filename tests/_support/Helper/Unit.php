<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use AspectMock\Test;
use Codeception\TestInterface;

class Unit extends \Codeception\Module
{
    public function _after(TestInterface $test)
    {
        parent::_after($test);
        Test::clean();
    }
}
