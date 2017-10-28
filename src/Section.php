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

use TypistTech\WPKsesView\Factory;
use TypistTech\WPKsesView\ViewAwareTrait;
use TypistTech\WPKsesView\ViewAwareTraitInterface;
use TypistTech\WPKsesView\ViewInterface;
use UnexpectedValueException;

class Section implements SectionInterface, ViewAwareTraitInterface
{
    use ViewAwareTrait {
        getView as protected traitGetView;
    }

    /**
     * String for use in the 'id' attribute of tags.
     *
     * @var string
     */
    private $id;

    /**
     * Title of the section.
     *
     * @var string
     */
    private $title;

    /**
     * Section constructor.
     *
     * @param string $id    String for use in the 'id' attribute of tags.
     * @param string $title Title of the section.
     */
    public function __construct($id, $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

    /**
     * Id getter.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
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

    /**
     * View getter.
     *
     * @return ViewInterface
     */
    public function getView(): ViewInterface
    {
        try {
            return $this->traitGetView();
        } catch (UnexpectedValueException $_exception) {
            $this->view = Factory::build(__DIR__ . '/partials/section.php');

            return $this->view;
        }
    }
}
