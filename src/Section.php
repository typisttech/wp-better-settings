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

use TypistTech\WPBetterSettings\Fields\AbstractField;

/**
 * Final class Section
 */
final class Section
{
    use ExtraAwareTrait;
    use ViewAwareTrait;

    /**
     * Fields of this section.
     *
     * @var AbstractField[]
     */
    private $fields = [];

    /**
     * The page slug name which this section should be shown.
     *
     * @var string
     */
    private $page;

    /**
     * Title of the section.
     *
     * @var string
     */
    private $title;

    /**
     * Section constructor.
     *
     * @param string             $page   The page slug name which this section should be shown.
     * @param string             $title  Title of the section.
     * @param array              $fields Fields of this section.
     * @param array|null         $extra  Optional. Additional information that is passed to the template
     *                                   partial through view object.
     * @param ViewInterface|null $view   Optional. ViewInterface object to render.
     */
    public function __construct(
        string $page,
        string $title,
        array $fields,
        array $extra = null,
        ViewInterface $view = null
    ) {
        $this->page = $page;
        $this->title = $title;
        $this->setFields(...$fields);

        $this->extra = $extra ?? [];
        $this->view = $view ?? ViewFactory::build('section');
    }

    /**
     * Get description from extra.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->extra['desc'] ?? '';
    }

    /**
     * Fields getter.
     *
     * @return AbstractField[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * Fields setter.
     *
     * @param AbstractField|AbstractField[] ...$fields Fields to be added.
     *
     * @return void
     */
    public function setFields(AbstractField ...$fields)
    {
        $this->fields = array_unique(
            array_merge($this->fields, $fields),
            SORT_REGULAR
        );
    }

    /**
     * Page getter.
     *
     * @return string
     */
    public function getPage(): string
    {
        return $this->page;
    }

    /**
     * Title getter.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}
