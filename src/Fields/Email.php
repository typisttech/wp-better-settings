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

namespace TypistTech\WPBetterSettings\Fields;

use TypistTech\WPBetterSettings\View;
use TypistTech\WPBetterSettings\ViewFactory;

/**
 * Final class Email
 */
final class Email extends AbstractInput
{
    const TYPE = 'email';

    /**
     * {@inheritdoc}
     */
    public function getSanitizeCallback(): callable
    {
        return $this->sanitizeCallback ?? [ $this, 'sanitizeEmail' ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultView(): View
    {
        return ViewFactory::build('fields/input');
    }

    /**
     * Sanitize email
     *
     * Strips out all characters that are not allowable in an email address.
     * Add settings error if email is not valid.
     *
     * @param string $input Input email.
     *
     * @return string Valid email address OR empty string.
     */
    public function sanitizeEmail(string $input): string
    {
        $sanitizedInput = sanitize_email($input);
        if (! is_email($sanitizedInput)) {
            // @codingStandardsIgnoreStart
            $errorMessage = __(
                'Sorry, that isn&#8217;t a valid email address. Email addresses look like <code>username@example.com</code>.',
                'wp-better-settings'
            );
            // @codingStandardsIgnoreEnd
            add_settings_error($this->id, 'invalid_' . $this->id, $errorMessage);
        }

        return $sanitizedInput;
    }
}
