<?php
/**
 * WP Better Settings
 *
 * A simplified OOP implementation of the WP Settings API.
 *
 * @package TypistTech\WPBetterSettings
 *
 * @author Typist Tech <wp-better-settings@typist.tech>
 * @copyright 2017 Typist Tech
 * @license GPL-2.0+
 *
 * @see https://www.typist.tech/projects/wp-better-settings
 * @see https://github.com/TypistTech/wp-better-settings
 */

declare(strict_types=1);

namespace TypistTech\WPBetterSettings\Fields;

use TypistTech\WPBetterSettings\View;
use TypistTech\WPBetterSettings\ViewFactory;

/**
 * Final class Checkbox
 */
final class Checkbox extends AbstractField
{
    /**
     * Get label form extra.
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->extra['label'] ?? '';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultView(): View
    {
        return ViewFactory::build('fields/checkbox');
    }

    /**
     * {@inheritdoc}
     */
    public function getSanitizeCallback(): callable
    {
        return $this->sanitizeCallback ?? [ $this, 'sanitizeCheckbox' ];
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
    public function sanitizeCheckbox(string $input): string
    {
        $sanitizedInput = sanitize_text_field($input);

        return ('1' === $sanitizedInput) ? '1' : '';
    }
}
