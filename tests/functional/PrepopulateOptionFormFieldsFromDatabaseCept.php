<?php

declare(strict_types=1);

use TypistTech\WPBetterSettings\FunctionalTester;

$I = new FunctionalTester($scenario);
$I->wantToTest('option form fields are pre-populated database values');

$I->amGoingTo('set options in database');
$I->haveOptionInDatabase('wpbs_simple_text', 'Jane Doe');
$I->haveOptionInDatabase('wpbs_simple_email', 'janedoe@example.com');
$I->haveOptionInDatabase('wpbs_simple_url', 'https://www.example.com/janedoe');
$I->haveOptionInDatabase('wpbs_simple_textarea', 'I am jane doe.');
$I->haveOptionInDatabase('wpbs_simple_checkbox', '1');

$I->amOnWPBSOptionPage();

$I->wantToTest('options are pre-populated');
$expected = [
    'wpbs_simple_text' => 'Jane Doe',
    'wpbs_simple_email' => 'janedoe@example.com',
    'wpbs_simple_url' => 'https://www.example.com/janedoe',
    'wpbs_simple_textarea' => 'I am jane doe.',
    'wpbs_simple_checkbox' => '1',
];
$I->seeInFormFields('form', $expected);
