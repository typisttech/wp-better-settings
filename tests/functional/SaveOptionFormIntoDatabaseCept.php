<?php

declare(strict_types=1);

use TypistTech\WPBetterSettings\FunctionalTester;

$I = new FunctionalTester($scenario);
$I->wantToTest('option form save options into database');

$I->amOnWPBSOptionPage();

$I->amGoingTo('submit option form');
$formValues = [
    'wpbs_option_1' => [
        'my_name' => 'Jane Doe',
        'my_email' => 'janedoe@example.com',
        'my_url' => 'https://www.example.com/janedoe',
        'my_textarea' => 'I am jane doe.',
        'my_checkbox' => true,
    ],
];
$I->submitForm('form', $formValues);

$I->wantToTest('options are saved into database and checkbox is transformed into 1');
$I->seeOptionInDatabase([
    'option_name' => 'wpbs_option_1',
    'option_value' => [
        'my_name' => 'Jane Doe',
        'my_email' => 'janedoe@example.com',
        'my_url' => 'https://www.example.com/janedoe',
        'my_textarea' => 'I am jane doe.',
        'my_checkbox' => '1',
    ],
]);
