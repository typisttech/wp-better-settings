<?php

declare(strict_types=1);

use TypistTech\WPBetterSettings\AcceptanceTester;

$I = new AcceptanceTester($scenario);
$I->wantToTest('input fields');

$I->amOnWPBSOptionPage();

$I->wantToTest('input field type attribute');
$I->seeElement('input', [
    'type' => 'text',
]);
$I->seeElement('input', [
    'type' => 'email',
]);
$I->seeElement('input', [
    'type' => 'url',
]);

$I->wantToTest('input field name attribute');
$actualNames = $I->grabMultiple('input', 'name');
$I->assertContains('wpbs_option_1[my_name]', $actualNames);
$I->assertContains('wpbs_option_1[my_email]', $actualNames);
$I->assertContains('wpbs_option_1[my_url]', $actualNames);
$I->assertContains('wpbs_option_1[my_disabled_input]', $actualNames);

$I->wantToTest('input field id attribute');
$actualIds = $I->grabMultiple('input', 'id');
$I->assertContains('my_name', $actualIds);
$I->assertContains('my_email', $actualIds);
$I->assertContains('my_url', $actualIds);
$I->assertContains('my_disabled_input', $actualIds);

$I->wantToTest('input field aria-describedby attribute');
$actualAriaDescribedby = $I->grabMultiple('input', 'aria-describedby');
$I->assertContains('my_disabled_input-description', $actualAriaDescribedby);

$I->wantToTest('input field disabled attribute');
$actualDisabled = $I->grabMultiple('input', 'disabled');
$I->assertContains(true, $actualDisabled);

$I->wantToTest('input field description paragraph');
$I->see('I am a description paragraph', [
    'css' => 'p.description',
]);
