<?php
$I = new AcceptanceTester($scenario);
$I->amOnWPBSOptionPage();

$I->wantToTest('two textarea fields exist');
$I->seeNumberOfElements('textarea', 2);

$I->wantToTest('textarea field name attribute');
$actualNames = $I->grabMultiple('textarea', 'name');
$expectedNames = ['wpbs_option_1[my_textarea]', 'wpbs_option_1[my_disabled_textarea]'];
$I->assertSame($expectedNames, $actualNames);

$I->wantToTest('textarea field id attribute');
$actualIds = $I->grabMultiple('textarea', 'id');
$expectedIds = ['my_textarea', 'my_disabled_textarea'];
$I->assertSame($expectedIds, $actualIds);

$I->wantToTest('textarea field rows attribute');
$actualRows = $I->grabMultiple('textarea', 'rows');
$I->assertContains(11, $actualRows);

$I->wantToTest('textarea field aria-describedby attribute');
$actualAriaDescribedby = $I->grabMultiple('textarea', 'aria-describedby');
$I->assertContains('my_disabled_textarea-description', $actualAriaDescribedby);

$I->wantToTest('textarea field disabled attribute');
$actualDisabled = $I->grabMultiple('textarea', 'disabled');
$I->assertContains(true, $actualDisabled);

$I->wantToTest('textarea field description paragraph');
$I->see('You shall not type', [ 'css' => 'p.description' ]);
