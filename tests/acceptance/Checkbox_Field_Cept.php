<?php
$I = new AcceptanceTester($scenario);
$I->amOnWPBSOptionPage();

$I->wantToTest('two checkbox fields exist');
$I->seeNumberOfElements('input[type="checkbox"]', 2);

$I->wantToTest('checkbox field name attribute');
$actualNames   = $I->grabMultiple('input[type="checkbox"]', 'name');
$expectedNames = [ 'wpbs_option_1[my_checkbox]', 'wpbs_option_1[my_disabled_checkbox]' ];
$I->assertSame($expectedNames, $actualNames);

$I->wantToTest('checkbox field id attribute');
$actualIds   = $I->grabMultiple('input[type="checkbox"]', 'id');
$expectedIds = [ 'my_checkbox', 'my_disabled_checkbox' ];
$I->assertSame($expectedIds, $actualIds);

$I->wantToTest('checkbox field aria-describedby attribute');
$actualAriaDescribedby = $I->grabMultiple('input[type="checkbox"]', 'aria-describedby');
$I->assertContains('my_checkbox-description', $actualAriaDescribedby);
$I->assertContains('my_disabled_checkbox-description', $actualAriaDescribedby);

$I->wantToTest('checkbox field disabled attribute');
$actualDisabled = $I->grabMultiple('input[type="checkbox"]', 'disabled');
$I->assertContains(true, $actualDisabled);

$I->wantToTest('checkbox field description paragraph');
$I->see('Checkmate', [ 'css' => 'p.description' ]);

$I->wantToTest('checkbox field label');
$I->see('Click me', [ 'css' => 'label[for="my_checkbox"]' ]);
