<?php
$I = new AcceptanceTester($scenario);
$I->wantToTest('menu page link');

$I->loginAsAdmin();
$I->waitForText('Dashboard', 10, 'h1');

$I->click('Settings');
$I->waitForElementVisible("a[href$='options-general.php?page=assb1_settings_2']", 10); // secs

$I->click('as-settings-better-v1');
$I->waitForText('as-settings-better-v1', 10, 'h1');

$I->seeInTitle('as-settings-better-v1');
$I->seeInCurrentUrl('/wp-admin/options-general.php?page=assb1_settings_2');
