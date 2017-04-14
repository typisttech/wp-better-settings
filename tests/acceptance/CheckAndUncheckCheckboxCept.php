<?php

declare(strict_types=1);

use TypistTech\WPBetterSettings\AcceptanceTester;

$I = new AcceptanceTester($scenario);
$I->wantToTest('checking and un-checking checkbox');

$I->amOnWPBSOptionPage();
$I->dontSeeCheckboxIsChecked('#my_checkbox');

$I->amGoingTo('check and submit the checkbox');
$formValues = [
    'wpbs_option_1[my_checkbox]' => '1',
];
$I->submitForm('form', $formValues);

$I->amOnWPBSOptionPage();
$I->seeCheckboxIsChecked('#my_checkbox');

$I->amGoingTo('un-check and submit the checkbox');
$formValues = [
    'wpbs_option_1[my_checkbox]' => '',
];
$I->submitForm('form', $formValues);

$I->amOnWPBSOptionPage();
$I->dontSeeCheckboxIsChecked('#my_checkbox');
