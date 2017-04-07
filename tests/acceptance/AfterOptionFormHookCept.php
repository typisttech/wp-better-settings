<?php use TypistTech\WPBetterSettings\AcceptanceTester;

$I = new AcceptanceTester($scenario);

$I->amOnWPBSOptionPage();

$I->see('This paragraph is add via {$snakecased_menu_slug}_after_option_form hook');
