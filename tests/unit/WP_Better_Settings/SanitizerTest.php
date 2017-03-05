<?php
namespace WP_Better_Settings;

use phpmock\phpunit\PHPMock;

/**
 * @coversDefaultClass \WPBS\Sanitizer
 */
class SanitizerTest extends \Codeception\Test\Unit
{
    use PHPMock;

    /**
     * @covers ::sanitize_checkbox
     */
    public function testSanitizeValidCheckbox()
    {
        $validInputs = [
            true,
            '1',
            1,
        ];

        foreach ($validInputs as $validInput) {
            $actual = Sanitizer::sanitize_checkbox($validInput);
            $this->assertSame('1', $actual, "$validInput should be sanitized to '1'");
        }
    }

    /**
     * @covers ::sanitize_checkbox
     */
    public function testSanitizeValidUnsettedCheckbox()
    {
        $actual = Sanitizer::sanitize_checkbox('');
        $this->assertSame('', $actual, 'Empty string should be sanitized to empty string');
    }

    /**
     * @covers ::sanitize_checkbox
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
            $actual = Sanitizer::sanitize_checkbox($invalidInput);
            $this->assertSame('', $actual, "$invalidInput should be sanitized to empty string");
        }
    }

    /**
     * @covers ::sanitize_email
     */
    public function testSanitizeValidEmail()
    {
        $actual = Sanitizer::sanitize_email('valid_e.mail+address@gmail.com', 'my_email_id');
        $this->assertSame('valid_e.mail+address@gmail.com', $actual);
    }

    /**
     * @covers ::sanitize_email
     */
    public function testSanitizeInvalidEmailAddSettingsError()
    {
        $errorMessage = 'The email address entered did not appear to be a valid email address. ';
        $errorMessage .= 'Please enter a valid email address.';
        $addSettingsError = $this->getFunctionMock(__NAMESPACE__, 'add_settings_error');
        $addSettingsError->expects($this->once())
                         ->with(
                             $this->equalTo('my_email_id'),
                             $this->equalTo('invalid_my_email_id'),
                             $this->equalTo($errorMessage)
                         );

        Sanitizer::sanitize_email('invalid_email@gmail', 'my_email_id');
    }

    /**
     * @covers ::sanitize_email
     */
    public function testSanitizeInvalidEmailToEmptyString()
    {
        $actual = Sanitizer::sanitize_email('invalid_email@gmail', 'my_email_id');
        $this->assertSame('', $actual);
    }
}
