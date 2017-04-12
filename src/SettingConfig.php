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

use UnexpectedValueException;

/**
 * Config details for a settings field.
 *
 * Details for a single set of settings.
 *
 * Valid keys:
 *
 * 'option_group' (string)          =>  A settings group name.
 *                                      Should correspond to a whitelisted option
 *                                      key name.
 *
 * 'option_name' (string)           =>  The name of an option to sanitize and save.
 *
 * 'sections' (Section_Config[])    =>  Array of Section_Config to add to the settings page.
 */
class SettingConfig extends Config
{
    use ViewEchoTrait;

    /**
     * Sanitize settings fields.
     *
     * @param array $input The value entered in the field.
     *
     * @throws \UnexpectedValueException If fields is not Field_Config[].
     *
     * @return array The sanitized values.
     */
    public function callFieldSanitizeFun(array $input)
    {
        $fieldIds = array_keys($input);
        $fieldIds = array_filter($fieldIds);
        $fieldConfigs = $this->getFieldsBy($fieldIds);

        foreach ($fieldConfigs as $fieldConfig) {
            $sanitizeCallback = $fieldConfig->getKey('sanitize_callback');
            if (! is_callable($sanitizeCallback)) {
                continue;
            }

            $id = $fieldConfig->getKey('id');
            $input[ $id ] = $sanitizeCallback($input[ $id ], $id);
        }

        // Unset empty elements.
        return array_filter($input);
    }

    /**
     * Get fields by ids.
     *
     * @param array $ids IDs of the fields to return.
     *
     * @throws \UnexpectedValueException If section.fields is not Field_Config[].
     *
     * @return FieldConfig[]
     */
    private function getFieldsBy(array $ids): array
    {
        $ids = array_filter($ids);
        $allFields = $this->getFields();

        return array_filter($allFields, function (FieldConfig $field) use ($ids) {
            $id = $field->getKey('id');

            return in_array($id, $ids, true);
        });
    }

    /**
     * Get all fields.
     *
     * @throws \UnexpectedValueException If sections.fields is not Field_Config[].
     *
     * @return FieldConfig[]
     */
    public function getFields(): array
    {
        $sections = $this->getSections();

        $pluck = array_map(
            function (SectionConfig $section) {
                return $section->getFields();
            },
            $sections
        );

        return array_merge(...$pluck);
    }

    /**
     * Sections getter.
     *
     * @throws \UnexpectedValueException If sections is not Section_Config[].
     *
     * @return SectionConfig[]
     */
    public function getSections(): array
    {
        $this->validateSections();

        return $this->getKey('sections');
    }

    /**
     * Check the sections.
     *
     * @throws UnexpectedValueException If fields is not SectionConfig[].
     *
     * @return void
     */
    private function validateSections()
    {
        $sections = $this->getKey('sections');
        if (! is_array($sections)) {
            $errorMessage = 'Sections in class ' . __CLASS__ . ' must be SectionConfig[]';
            throw new UnexpectedValueException($errorMessage);
        }

        foreach ($sections as $section) {
            if (! $section instanceof SectionConfig) {
                $errorMessage = 'Section items in class ' . __CLASS__ . ' must be instances of SectionConfig.';
                throw new UnexpectedValueException($errorMessage);
            }
        }
    }

    /**
     * Default config of Setting_Config.
     *
     * @return array
     */
    protected function defaultConfig(): array
    {
        return [
            'view' => ViewFactory::build('section-description'),
            'function' => [ $this, 'echoView' ],
            'args' => [
                'sanitize_callback' => [ $this, 'callFieldSanitizeFun' ],
            ],
        ];
    }
}
