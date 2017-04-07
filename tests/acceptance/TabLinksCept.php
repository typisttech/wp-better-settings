<?php use TypistTech\WPBetterSettings\AcceptanceTester;

$I = new AcceptanceTester($scenario);
$I->wantToTest('tab links');

$I->amOnWPBSOptionPage();

$I->seeElement('#wpbs_1-tab');
$I->seeElement('#wpbs_2-tab');
