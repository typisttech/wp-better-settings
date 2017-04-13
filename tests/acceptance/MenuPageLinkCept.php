<?php

declare(strict_types=1);

use TypistTech\WPBetterSettings\AcceptanceTester;

$I = new AcceptanceTester($scenario);
$I->wantToTest('menu page link');

$I->loginAsAdmin();
$I->waitForText('Dashboard', 10, 'h1');
$I->waitForElementVisible("a[href$='admin.php?page=wpbs_1']", 10); // secs.

$I->moveMouseOver("a[href$='admin.php?page=wpbs_1']");
$I->waitForElementVisible("a[href$='admin.php?page=wpbs_2']", 10);

$I->click('WPBS Two');
$I->waitForText('WP Better Settings Two', 10, 'h1');

$I->seeInCurrentUrl('/wp-admin/admin.php?page=wpbs_2');
$I->see('completely useless');
