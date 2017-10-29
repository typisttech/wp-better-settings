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

class Registrar
{
    /**
     * The slug-name of the settings page on which to show the section.
     *
     * @var string
     */
    private $pageSlug;

    /**
     * Sections to be registered.
     *
     * @var SectionInterface[]
     */
    private $sections = [];

    /**
     * Registrar constructor.
     *
     * @param string $pageSlug The slug-name of the settings page on which to show the section.
     */
    public function __construct($pageSlug)
    {
        $this->pageSlug = $pageSlug;
    }

    /**
     * Register sections with WordPress.
     *
     * @void
     */
    public function run()
    {
        array_map(
            function (SectionInterface $section) {
                $this->registerSection($section);
                $this->registerFields($section);
                $this->registerSettings($section);
            },
            $this->sections
        );
    }

    /**
     * Register a section to the settings page with WordPress.
     *
     * @param SectionInterface $section Section to be registered.
     *
     * @void
     */
    private function registerSection(SectionInterface $section)
    {
        add_settings_section(
            $section->getId(),
            $section->getTitle(),
            $section->getRenderClosure(),
            $this->pageSlug
        );
    }

    /**
     * Register fields of a section with WordPress.
     *
     * @param SectionInterface $section Section which holds a list of its fields.
     *
     * @return void
     */
    private function registerFields(SectionInterface $section)
    {
        array_map(
            function (FieldInterface $field) use ($section) {
                add_settings_field(
                    $field->getId(),
                    $field->getTitle(),
                    $field->getRenderClosure(),
                    $this->pageSlug,
                    $section->getId(),
                    $field->getAdditionalRenderArguments()
                );
            },
            $section->getFields()
        );
    }

    /**
     * Register a setting and its data with WordPress.
     *
     * @param SectionInterface $section Section which holds a list of its fields.
     *
     * @return void
     */
    private function registerSettings(SectionInterface $section)
    {
        array_map(
            function (FieldInterface $field) {
                register_setting(
                    $this->pageSlug,
                    $field->getId(),
                    $field->getAdditionalSettingArguments()
                );
            },
            $section->getFields()
        );
    }

    /**
     * Add sections to
     *
     * @param SectionInterface[] ...$sections Sections to be registered.
     */
    public function add(SectionInterface ...$sections)
    {
        $this->sections = array_merge(
            $this->sections,
            $sections
        );
    }
}
