<?php
namespace WPBS\WP_Better_Settings;

use phpmock\phpunit\PHPMock;

/**
 * @coversDefaultClass \WPBS\WP_Better_Settings\Sanitizer
 */
class SanitizerTest extends \Codeception\TestCase\WPTestCase
{
    use PHPMock;

    /**
     * @covers ::sanitize_checkbox
     */
    public function testSanitizeValidCheckbox()
    {
        $valid_inputs = [
            true,
            '1',
            1,
        ];

        foreach ($valid_inputs as $valid_input) {
            $actual = Sanitizer::sanitize_checkbox($valid_input);
            $this->assertSame('1', $actual, "$valid_input should be sanitized to '1'");
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
        $invalid_inputs = [
            'checked',
            'false',
            false,
            'true',
            '0',
            0,
        ];

        foreach ($invalid_inputs as $invalid_input) {
            $actual = Sanitizer::sanitize_checkbox($invalid_input);
            $this->assertSame('', $actual, "$invalid_input should be sanitized to empty string");
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
        $add_settings_error = $this->getFunctionMock(__NAMESPACE__, 'add_settings_error');
        $add_settings_error->expects($this->once())
                           ->with(
                               $this->equalTo('my_email_id'),
                               $this->equalTo('invalid_my_email_id'),
                               $this->equalTo('The email address entered did not appear to be a valid email address. Please enter a valid email address.')
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
