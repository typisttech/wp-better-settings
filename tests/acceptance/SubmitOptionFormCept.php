<?php

declare(strict_types=1);

use TypistTech\WPBetterSettings\AcceptanceTester;

$I = new AcceptanceTester($scenario);
$I->wantToTest('option form submission');

$I->amOnWPBSOptionPage();

$I->amGoingTo('submit a form');
$formValues = [
    'wpbs_simple_text' => 'Jane Doe',
    'wpbs_simple_email' => 'janedoe@example.com',
    'wpbs_simple_url' => 'https://www.example.com/janedoe',
    'wpbs_simple_textarea' => 'I am jane doe.',
    'wpbs_simple_checkbox' => '1',
];
$I->submitForm('form', $formValues);

$I->amGoingTo('wait for form submission');
$I->waitForText('Settings saved', 10);

$I->wantToTest('options are saved');
$I->seeInFormFields('form', $formValues);
