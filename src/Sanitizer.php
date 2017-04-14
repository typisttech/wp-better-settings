<?php
/**
 * WP Better Settings
 *
 * A simplified OOP implementation of the WP Settings API.
 *
 * @package   TypistTech\WPBetterSettings
 *
 * @author    Typist Tech <wp-better-settings@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   GPL-2.0+
 *
 * @see       https://www.typist.tech/projects/wp-better-settings
 * @see       https://github.com/TypistTech/wp-better-settings
 */

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

/**
 * Final class Sanitizer.
 */
final class Sanitizer
{
    /**
     * Private constructor.
     */
    private function __construct()
    {
    }

    /**
     * Sanitize checkbox
     *
     * Sanitize any input other than '1' to empty string.
     *
     * @param string $input User submitted value.
     *
     * @return string Empty string OR '1'
     */
    public static function sanitizeCheckbox(string $input): string
    {
        $sanitizedInput = sanitize_text_field($input);
        if ('1' !== $sanitizedInput) {
            $sanitizedInput = '';
        }

        return $sanitizedInput;
    }

    /**
     * Sanitize email
     *
     * Strips out all characters that are not allowable in an email address.
     * Add settings error if email is not valid.
     *
     * @param string $input   Input email.
     * @param string $fieldId ID of the settings field.
     *
     * @return string Valid email address OR empty string.
     */
    public static function sanitizeEmail(string $input, string $fieldId): string
    {
        $sanitizedInput = sanitize_email($input);
        if (! is_email($sanitizedInput)) {
            // @codingStandardsIgnoreStart
            $errorMessage = __(
                'Sorry, that isn&#8217;t a valid email address. Email addresses look like <code>username@example.com</code>.',
                'wp-better-settings'
            );
            // @codingStandardsIgnoreEnd
            add_settings_error($fieldId, 'invalid_' . $fieldId, $errorMessage);
        }

        return $sanitizedInput;
    }
}
