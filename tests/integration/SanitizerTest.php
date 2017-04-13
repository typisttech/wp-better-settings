<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

use AspectMock\Test;

/**
 * @coversDefaultClass \TypistTech\WPBetterSettings\Sanitizer
 */
class SanitizerTest extends \Codeception\TestCase\WPTestCase
{
    /**
     * @var \AspectMock\Proxy\FuncProxy
     */
    private $addSettingsError;

    public function invalidCheckboxInputProvider(): array
    {
        return [
            'checked' => [ 'checked' ],
            'false' => [ 'false' ],
            'true' => [ 'true' ],
            'minus one' => [ '-1' ],
            'zero' => [ '0' ],
            'eleven' => [ '11' ],
        ];
    }

    /**
     * @covers ::sanitizeCheckbox
     *
     * @dataProvider invalidCheckboxInputProvider
     *
     * @param string $invalidCheckboxInput The invalid checkbox input.
     */
    public function testSanitizeInvalidCheckbox(string $invalidCheckboxInput)
    {
        $actual = Sanitizer::sanitizeCheckbox($invalidCheckboxInput);
        $this->assertSame('', $actual);
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
        $actual = Sanitizer::sanitizeCheckbox('1');
        $this->assertSame('1', $actual);
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
        $this->assertSame('', $actual);
    }

    protected function _before()
    {
        $this->addSettingsError = Test::func(__NAMESPACE__, 'add_settings_error', true);
    }
}
