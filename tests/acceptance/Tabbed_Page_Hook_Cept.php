<?php
$I = new AcceptanceTester($scenario);

$I->amOnWPBSOptionPage();

$I->see('This paragraph is add via {$menu_page_config->menu_slug}_after_option_form hook');
