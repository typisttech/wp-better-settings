<?php use TypistTech\WPBetterSettings\AcceptanceTester;

$I = new AcceptanceTester($scenario);
$I->wantToTest('option form submission');

$I->amOnWPBSOptionPage();

$I->amGoingTo('submit a form');
$formValues = [
    'wpbs_option_1[my_name]'     => 'Jane Doe',
    'wpbs_option_1[my_email]'    => 'janedoe@example.com',
    'wpbs_option_1[my_url]'      => 'https://www.example.com/janedoe',
    'wpbs_option_1[my_textarea]' => 'I am jane doe.',
    'wpbs_option_1[my_checkbox]' => true,
];
$I->submitForm('form', $formValues);

$I->amGoingTo('wait for form submission');
$I->waitForText('Settings saved', 10);

$I->wantToTest('options are saved');
$I->seeInFormFields('form', $formValues);
