<?php
namespace WP_Better_Settings;

use phpmock\phpunit\PHPMock;

/**
 * @coversDefaultClass \WP_Better_Settings\Sanitizer
 */
class Sanitizer_Test extends \Codeception\Test\Unit
{
    use PHPMock;

    /**
     * @test
     * @covers ::sanitize_checkbox
     */
    public function it_sanitize_valid_checkbox()
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
     * @test
     * @covers ::sanitize_checkbox
     */
    public function it_sanitize_valid_unchecked_checkbox()
    {
        $actual = Sanitizer::sanitize_checkbox('');
        $this->assertSame('', $actual, 'Empty string should be sanitized to empty string');
    }

    /**
     * @test
     * @covers ::sanitize_checkbox
     */
    public function it_sanitize_invalid_checkbox()
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
     * @test
     * @covers ::sanitize_email
     */
    public function it_sanitize_valid_email()
    {
        $actual = Sanitizer::sanitize_email('valid_e.mail+address@gmail.com', 'my_email_id');
        $this->assertSame('valid_e.mail+address@gmail.com', $actual);
    }

    /**
     * @test
     * @covers ::sanitize_email
     */
    public function it_sanitize_invalid_email_add_settings_error()
    {
        $error_message = 'Sorry, that isn&#8217;t a valid email address. ';
        $error_message .= 'Email addresses look like <code>username@example.com</code>.';
        $add_settings_error_mock = $this->getFunctionMock(__NAMESPACE__, 'add_settings_error');
        $add_settings_error_mock->expects($this->once())
                                ->with(
                                    $this->equalTo('my_email_id'),
                                    $this->equalTo('invalid_my_email_id'),
                                    $this->equalTo($error_message)
                                );

        Sanitizer::sanitize_email('invalid_email@gmail', 'my_email_id');
    }

    /**
     * @test
     * @covers ::sanitize_email
     */
    public function it_sanitize_invalid_email_to_empty_string()
    {
        $actual = Sanitizer::sanitize_email('invalid_email@gmail', 'my_email_id');
        $this->assertSame('', $actual);
    }

    protected function _before()
    {
        PHPMock::defineFunctionMock(__NAMESPACE__, 'add_settings_error');
        parent::_before();
    }
}
