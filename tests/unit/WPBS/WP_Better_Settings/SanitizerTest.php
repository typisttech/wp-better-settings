<?php
namespace WPBS\WP_Better_Settings;

use AspectMock\Test;

/**
 * @coversDefaultClass \WPBS\WP_Better_Settings\Sanitizer
 */
class SanitizerTest extends \Codeception\TestCase\WPTestCase
{
    /**
     * @covers ::sanitize_settings
     */
    public function testSanitizeSettingsUnsetEmptyElements()
    {
        $config = new SettingConfig();
        $input  = [
            'field-false'        => false,
            'field-empty-array'  => [],
            'field-empty-string' => '',
            'field-null'         => null,
            'field-one'          => '1',
            'field-something'    => 'something',
            'field-zero'         => 0,
            'field-zero-string'  => '0',
        ];

        $expected = [
            'field-one'       => '1',
            'field-something' => 'something',
        ];

        $actual = Sanitizer::sanitize_settings($config, $input);
        $this->assertSame($expected, $actual);
    }

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
    public function testSanitizeInvalidEmail()
    {
        $func = Test::func('WPBS\WP_Better_Settings', 'add_settings_error', null);

        $actual = Sanitizer::sanitize_email('invalid_email@gmail', 'my_email_id');

        $this->assertSame('', $actual);
        $func->verifyInvokedOnce([
            'my_email_id',
            'invalid_my_email_id',
            'The email address entered did not appear to be a valid email address. Please enter a valid email address.'
        ]);
    }
}
