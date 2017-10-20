<?php

declare(strict_types=1);

use TypistTech\WPBetterSettings\FunctionalTester;

$I = new FunctionalTester($scenario);
$I->wantToTest('un-checking checkbox removes option value from database');

$I->amGoingTo('set options in database');
$I->haveOptionInDatabase('wpbs_simple_checkbox', '1');

$I->amOnWPBSOptionPage();
$I->seeCheckboxIsChecked('#wpbs_simple_checkbox');

$I->amGoingTo('un-check and submit the checkbox');
$I->uncheckOption('#wpbs_simple_checkbox');
$I->click('#submit');

$I->wantToTest('option value is removed from database');
$I->dontSeeOptionInDatabase(
    [
        'option_name' => 'wpbs_1',
    ]
);
