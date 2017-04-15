<?php

declare(strict_types=1);

use TypistTech\WPBetterSettings\AcceptanceTester;

$I = new AcceptanceTester($scenario);
$I->wantToTest('tab links');

$I->amOnWPBSOptionPage();

$I->seeElement('#wpbs-1-tab');
$I->seeElement('#wpbs-2-tab');
