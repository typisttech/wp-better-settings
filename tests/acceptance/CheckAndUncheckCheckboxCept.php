<?php

declare(strict_types=1);

use TypistTech\WPBetterSettings\AcceptanceTester;

$I = new AcceptanceTester($scenario);
$I->wantToTest('checking and un-checking checkbox');

$I->amOnWPBSOptionPage();
$I->dontSeeCheckboxIsChecked('#wpbs_simple_checkbox');

$I->amGoingTo('check and submit the checkbox');
$I->click('#wpbs_simple_checkbox');
$I->click('#submit');
$I->waitForText('Settings saved', 10);

$I->amOnAdminPage('admin.php?page=wpbs-simple');
$I->seeCheckboxIsChecked('#wpbs_simple_checkbox');

$I->amGoingTo('un-check and submit the checkbox');
$I->click('#wpbs_simple_checkbox');
$I->click('#submit');
$I->waitForText('Settings saved', 10);

$I->amOnAdminPage('admin.php?page=wpbs-simple');
$I->dontSeeCheckboxIsChecked('#wpbs_simple_checkbox');
