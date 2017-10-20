<?php

declare(strict_types=1);

use TypistTech\WPBetterSettings\FunctionalTester;

$I = new FunctionalTester($scenario);
$I->wantToTest('option form save options into database');

$I->amOnWPBSOptionPage();

$I->amGoingTo('submit option form');
$formValues = [
    'wpbs_simple_text' => 'Jane Doe',
    'wpbs_simple_email' => 'janedoe@example.com',
    'wpbs_simple_url' => 'https://www.example.com/janedoe',
    'wpbs_simple_textarea' => 'I am jane doe.',
    'wpbs_simple_checkbox' => '1',
];
$I->submitForm('form', $formValues);

$I->wantToTest('options are saved into database');
$I->seeOptionInDatabase(
    [
        'option_name' => 'wpbs_simple_text',
        'option_value' => 'Jane Doe',
    ]
);
$I->seeOptionInDatabase(
    [
        'option_name' => 'wpbs_simple_email',
        'option_value' => 'janedoe@example.com',
    ]
);
$I->seeOptionInDatabase(
    [
        'option_name' => 'wpbs_simple_url',
        'option_value' => 'https://www.example.com/janedoe',
    ]
);
$I->seeOptionInDatabase(
    [
        'option_name' => 'wpbs_simple_textarea',
        'option_value' => 'I am jane doe.',
    ]
);
$I->seeOptionInDatabase(
    [
        'option_name' => 'wpbs_simple_checkbox',
        'option_value' => '1',
    ]
);
