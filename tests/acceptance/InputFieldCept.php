<?php
$I = new AcceptanceTester($scenario);
$I->wantToTest('input fields');

$I->loginAsAdmin();
$I->waitForText('Dashboard', 10, 'h1');
$I->waitForElementVisible("a[href$='admin.php?page=wpbs_1']", 10); // secs

$I->click('WP Better Settings');
$I->click('WP Better Settings');
$I->waitForText('WP Better Settings', 10, 'h1');

$I->wantToTest('input field types');
$I->seeElement('input', [ 'type' => 'text' ]);
$I->seeElement('input', [ 'type' => 'email' ]);
$I->seeElement('input', [ 'type' => 'url' ]);

$I->wantToTest('input field attributes');
$inputAttributes = $I->grabMultiple('input', 'disabled');
$I->assertContains(true, $inputAttributes);

$I->wantToTest('input field description paragraph');
$I->see('I am a description paragraph', [ 'css' => 'p.description' ]);
