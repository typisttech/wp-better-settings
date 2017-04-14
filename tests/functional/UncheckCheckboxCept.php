<?php

declare(strict_types=1);

use TypistTech\WPBetterSettings\FunctionalTester;

$I = new FunctionalTester($scenario);
$I->wantToTest('un-checking checkbox removes option value from database');

$I->amGoingTo('set options in database');
$I->haveOptionInDatabase('wpbs_option_1', [
    'my_checkbox' => '1',
]);

$I->amOnWPBSOptionPage();
$I->seeCheckboxIsChecked('#my_checkbox');

$I->amGoingTo('un-check and submit the checkbox');
$I->uncheckOption('#my_checkbox');
$I->click('#submit');

$I->wantToTest('option value is removed from database');
$I->seeOptionInDatabase([
    'option_name' => 'wpbs_option_1',
    'option_value' => false,
]);
