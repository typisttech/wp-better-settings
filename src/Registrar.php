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
        $this->registerSections();
    }

    /**
     * Add sections to the settings page.
     *
     * @void
     */
    private function registerSections()
    {
        array_map(
            function (SectionInterface $section) {
                add_settings_section(
                    $section->getId(),
                    $section->getTitle(),
                    $section->getRenderClosure(),
                    $this->pageSlug
                );
            },
            $this->sections
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
