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

use AdamWathan\Form\Elements\FormControl;
use Closure;

class Field implements FieldInterface
{
    /**
     * String for use in the 'id' attribute of tags.
     *
     * @var string
     */
    private $id;

    /**
     * Title of the field.
     *
     * @var string
     */
    private $title;

    /**
     * Object that echos HTML tags.
     *
     * @var FormControl
     */
    private $formControl;

    /**
     * Field constructor.
     *
     * @param string      $id          String for use in the 'id' attribute of tags.
     * @param string      $title       Title of the field.
     * @param FormControl $formControl Object that echos HTML tags.
     */
    public function __construct(string $id, string $title, FormControl $formControl)
    {
        $this->id = $id;
        $this->title = $title;
        $this->formControl = $formControl;
    }

    /**
     * String for use in the 'id' attribute of tags.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Title of the field.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Closure that fills the field with the desired inputs as part of the larger form. The closure should echo its
     * output.
     *
     * @return Closure
     */
    public function getRenderClosure(): Closure
    {
        return function () {
            // @codingStandardsIgnoreStart
            echo $this->formControl->render();
            // @codingStandardsIgnoreEnd
        };
    }

    /**
     * Additional arguments that are passed to the render closure.
     *
     * @return array
     */
    public function getAdditionalRenderArguments(): array
    {
        return [
            'label_for' => $this->getId(),
        ];
    }
}
