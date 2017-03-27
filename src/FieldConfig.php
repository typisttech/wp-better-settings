<?php
/**
 * WP Better Settings
 *
 * A simplified OOP implementation of the WP Settings API.
 *
 * @package   TypistTech\WPBetterSettings
 * @author    Typist Tech <wp-better-settings@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   GPL-2.0+
 * @see       https://www.typist.tech/projects/wp-better-settings
 * @see       https://github.com/TypistTech/wp-better-settings
 */

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

/**
 * Class FieldConfig.
 *
 * Config details for a settings field.
 *
 * Valid keys:
 *
 * 'id' (string)                    =>  ID of this field. Should be unique for each page
 *
 * 'title' (string)                 =>  Title to display as the heading for
 *                                      the section.
 *
 * 'view' (string|View_Interface)   =>  View to use for rendering the
 *                                      section. Can be a path to a view file
 *                                      or an instance of a View object.
 *
 * @since 0.1.0
 */
class FieldConfig extends Config
{
    use ViewEchoTrait;

    /**
     * Default config of Field_Config.
     *
     * @since 0.1.0
     * @return array
     */
    protected function defaultConfig(): array
    {
        return [
            'callback'          => [ $this, 'echoView' ],
            'sanitize_callback' => 'sanitize_text_field',
        ];
    }
}
