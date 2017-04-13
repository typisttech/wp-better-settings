<?php

declare(strict_types=1);

use TypistTech\WPBetterSettings\AcceptanceTester;

$I = new AcceptanceTester($scenario);
$I->wantToTest('{$snakecased_menu_slug}_after_option_form hook');

$I->amOnWPBSOptionPage();

$I->see('This paragraph is add via {$snakecased_menu_slug}_after_option_form hook');
