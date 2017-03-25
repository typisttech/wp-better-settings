<?php

namespace TypistTech\WPBetterSettings;

use phpmock\phpunit\PHPMock;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\Sanitizer
 */
class SanitizerTest extends \Codeception\Test\Unit
{
    use PHPMock;

    /**
     * @covers ::sanitizeCheckbox
     */
    public function testSanitizeInvalidCheckbox()
    {
        $invalid_inputs = [
            'checked',
            'false',
            false,
            'true',
            '0',
            0,
        ];

        foreach ($invalid_inputs as $invalid_input) {
            $actual = Sanitizer::sanitizeCheckbox($invalid_input);
            $this->assertSame('', $actual, "$invalid_input should be sanitized to empty string");
        }
    }

    /**
     * @covers ::sanitizeEmail
     */
    public function testSanitizeInvalidEmailAddSettingsError()
    {
        $error_message           = 'Sorry, that isn&#8217;t a valid email address. ';
        $error_message           .= 'Email addresses look like <code>username@example.com</code>.';
        $add_settings_error_mock = $this->getFunctionMock(__NAMESPACE__, 'add_settings_error');
        $add_settings_error_mock->expects($this->once())
                                ->with(
                                    $this->equalTo('my_email_id'),
                                    $this->equalTo('invalid_my_email_id'),
                                    $this->equalTo($error_message)
                                );

        Sanitizer::sanitizeEmail('invalid_email@gmail', 'my_email_id');
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
        $valid_inputs = [
            true,
            '1',
            1,
        ];

        foreach ($valid_inputs as $valid_input) {
            $actual = Sanitizer::sanitizeCheckbox($valid_input);
            $this->assertSame('1', $actual, "$valid_input should be sanitized to '1'");
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
        PHPMock::defineFunctionMock(__NAMESPACE__, 'add_settings_error');
        parent::_before();
    }
}
