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

use UnexpectedValueException;

/**
 * Class SectionConfig.
 *
 * Config details for a settings field.
 *
 *
 * Details for a single section.
 *
 * Valid keys:
 *
 * 'title' (string)             =>  Title to display as the heading for the
 *                                  section.
 *
 * 'page' (string)              =>  The menu page on which to display this section.
 *                                  Should match $menu_slug in MenuPageConfig.
 *
 * 'view' (string|View)         =>  View to use for rendering the section. Can be
 *                                  a path to a view file or an instance of a
 *                                  View object.
 *
 * 'fields' (FieldConfig[])     =>  Array of FieldConfig to attach to this
 *                                  section.
 *
 * @since 0.1.0
 */
class SectionConfig extends Config
{
    use ViewEchoTrait;

    /**
     * Fields getter.
     *
     * @since 0.5.0
     * @return FieldConfig[]
     * @throws UnexpectedValueException If fields is not Field_Config[].
     */
    public function getFields(): array
    {
        $this->validateFields();

        return $this->getKey('fields');
    }

    /**
     * Check the fields.
     *
     * @since  0.5.0
     * @access private
     * @return void
     * @throws UnexpectedValueException If fields is not FieldConfig[].
     */
    private function validateFields()
    {
        $fields = $this->getKey('fields');
        if (! is_array($fields)) {
            $error_message = 'Fields in class ' . __CLASS__ . ' must be an array.';
            throw new UnexpectedValueException($error_message);
        }

        array_walk($fields, function ($field) {
            if (! $field instanceof FieldConfig) {
                $error_message = 'Field items in class ' . __CLASS__ . ' must be instances of FieldConfig.';
                throw new UnexpectedValueException($error_message);
            }
        });
    }

    /**
     * Default config of SectionConfig.
     *
     * @since 0.1.0
     * @return array
     */
    protected function defaultConfig(): array
    {
        return [
            'view'     => ViewFactory::build('section-description'),
            'callback' => [ $this, 'echoView' ],
        ];
    }
}
