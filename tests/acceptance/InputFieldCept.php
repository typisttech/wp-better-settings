<?php
$I = new AcceptanceTester($scenario);
$I->wantToTest('input fields');

$I->loginAsAdmin();
$I->waitForText('Dashboard', 10, 'h1');

$I->click('Settings');
$I->waitForElementVisible("a[href$='options-general.php?page=assb1_settings_2']", 10); // secs

$I->click('as-settings-better-v1');
$I->waitForText('as-settings-better-v1', 10, 'h1');

$I->wantToTest('input field types');
$I->seeElement('input', ['type' => 'text']);
$I->seeElement('input', ['type' => 'email']);
$I->seeElement('input', ['type' => 'url']);

$I->wantToTest('input field attributes');
$inputAttributes = $I->grabMultiple('input', 'disabled');
$I->assertContains(true, $inputAttributes);