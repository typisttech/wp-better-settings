<?php

namespace TypistTech\WPBetterSettings;

use AspectMock\Test;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\Sanitizer
 */
class SanitizerTest extends \Codeception\Test\Unit
{
    /**
     * @var \AspectMock\Proxy\FuncProxy
     */
    private $addSettingsError;

    /**
     * @covers ::sanitizeCheckbox
     */
    public function testSanitizeInvalidCheckbox()
    {
        $invalidInputs = [
            'checked',
            'false',
            false,
            'true',
            '0',
            0,
        ];

        foreach ($invalidInputs as $invalidInput) {
            $actual = Sanitizer::sanitizeCheckbox($invalidInput);
            $this->assertSame('', $actual, $invalidInput . ' should be sanitized to empty string');
        }
    }

    /**
     * @covers ::sanitizeEmail
     */
    public function testSanitizeInvalidEmailAddSettingsError()
    {
        $errorMessage = 'Sorry, that isn&#8217;t a valid email address. ';
        $errorMessage .= 'Email addresses look like <code>username@example.com</code>.';

        Sanitizer::sanitizeEmail('invalid_email@gmail', 'my_email_id');

        $this->addSettingsError->verifyInvokedMultipleTimes(1);
        $this->addSettingsError->verifyInvokedOnce([ 'my_email_id', 'invalid_my_email_id', $errorMessage ]);
    }

    /**
     * @covers ::sanitizeEmail
     */
    public function testSanitizeInvalidEmailToEmptyString()
    {
        $actual = Sanitizer::sanitizeEmail('invalid_email@gmail', 'my_email_id');
        $this->assertSame('', $actual);
    }

    /**
     * @covers ::sanitizeCheckbox
     */
    public function testSanitizeValidCheckbox()
    {
        $validInputs = [
            true,
            '1',
            1,
        ];

        foreach ($validInputs as $validInput) {
            $actual = Sanitizer::sanitizeCheckbox($validInput);
            $this->assertSame('1', $actual, $validInput . " should be sanitized to '1'");
        }
    }

    /**
     * @covers ::sanitizeEmail
     */
    public function testSanitizeValidEmail()
    {
        $actual = Sanitizer::sanitizeEmail('valid_e.mail+address@gmail.com', 'my_email_id');
        $this->assertSame('valid_e.mail+address@gmail.com', $actual);
    }

    /**
     * @covers ::sanitizeCheckbox
     */
    public function testSanitizeValidUncheckedCheckbox()
    {
        $actual = Sanitizer::sanitizeCheckbox('');
        $this->assertSame('', $actual, 'Empty string should be sanitized to empty string');
    }

    protected function _before()
    {
        $this->addSettingsError = Test::func(__NAMESPACE__, 'add_settings_error', true);
    }
}
