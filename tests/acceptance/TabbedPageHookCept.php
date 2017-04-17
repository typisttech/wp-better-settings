<?php

declare(strict_types=1);

use TypistTech\WPBetterSettings\AcceptanceTester;

$I = new AcceptanceTester($scenario);
$I->wantToTest('tabbed page hooks');

$I->amOnWPBSOptionPage();

$I->see('This paragraph is add via {$snakecased_menu_slug}_before_page_title hook');
$I->see('This paragraph is add via {$snakecased_menu_slug}_after_page_title hook');
$I->see('This paragraph is add via {$snakecased_menu_slug}_before_nav_tabs hook');
$I->see('This paragraph is add via {$snakecased_menu_slug}_after_nav_tabs hook');
$I->see('This paragraph is add via {$snakecased_menu_slug}_before_option_form hook');
$I->see('This paragraph is add via {$snakecased_menu_slug}_before_settings_sections hook');
$I->see('This paragraph is add via {$snakecased_menu_slug}_before_submit_button hook');
$I->see('This paragraph is add via {$snakecased_menu_slug}_after_submit_button hook');
$I->see('This paragraph is add via {$snakecased_menu_slug}_after_option_form hook');
