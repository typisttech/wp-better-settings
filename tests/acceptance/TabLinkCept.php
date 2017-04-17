<?php

declare(strict_types=1);

use TypistTech\WPBetterSettings\AcceptanceTester;

$I = new AcceptanceTester($scenario);
$I->wantToTest('tab links');

$I->amOnWPBSOptionPage();

$I->seeElement('#wpbs-simple-tab');
$I->seeElement('#wpbs-text-tab');
$I->seeElement('#wpbs-email-tab');
$I->seeElement('#wpbs-url-tab');
$I->seeElement('#wpbs-checkbox-tab');
$I->seeElement('#wpbs-textarea-tab');
$I->seeElement('#wpbs-basic-page-tab');
$I->seeElement('#wpbs-custom-view-tab');
