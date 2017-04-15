<?php

declare(strict_types=1);

use TypistTech\WPBetterSettings\FunctionalTester;

$I = new FunctionalTester($scenario);
$I->wantToTest('option form fields are pre-populated database values');

$I->amGoingTo('set options in database');
$I->haveOptionInDatabase('wpbs_1', [
    'my_name' => 'Jane Doe',
    'my_email' => 'janedoe@example.com',
    'my_url' => 'https://www.example.com/janedoe',
    'my_textarea' => 'I am jane doe.',
    'my_checkbox' => '1',
]);

$I->amOnWPBSOptionPage();

$I->wantToTest('options are saved');
$expected = [
    'wpbs_1[my_name]' => 'Jane Doe',
    'wpbs_1[my_email]' => 'janedoe@example.com',
    'wpbs_1[my_url]' => 'https://www.example.com/janedoe',
    'wpbs_1[my_textarea]' => 'I am jane doe.',
    'wpbs_1[my_checkbox]' => true,
];
$I->seeInFormFields('form', $expected);
