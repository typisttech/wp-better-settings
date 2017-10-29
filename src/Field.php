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
     * Extra arguments used when outputting the field.
     *
     * @var array
     */
    private $additionalRenderArguments;

    /**
     * Data used to describe the setting when registered.
     *
     * @var array
     */
    private $additionalSettingsArguments;

    /**
     * Field constructor.
     *
     * @param string      $id                          String for use in the 'id' attribute of tags.
     * @param string      $title                       Title of the field.
     * @param FormControl $formControl                 Object that echos HTML tags.
     * @param array       $additionalSettingsArguments Optional. Data used to describe the setting when registered.
     * @param array       $additionalRenderArguments   Optional. Extra arguments used when outputting the field.
     */
    public function __construct(
        string $id,
        string $title,
        FormControl $formControl,
        array $additionalSettingsArguments = null,
        array $additionalRenderArguments = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->formControl = $formControl;
        $this->additionalSettingsArguments = array_merge(
            $this->getDefaultAdditionalSettingArguments(),
            (array) $additionalSettingsArguments
        );
        $this->additionalRenderArguments = array_merge(
            $this->getDefaultAdditionalRenderArguments(),
            (array) $additionalRenderArguments
        );
    }

    /**
     * Default data used to describe the setting when registered.
     *
     * @return array
     */
    public function getDefaultAdditionalSettingArguments(): array
    {
        return [
            'sanitize_callback' => 'sanitize_text_field',
            'show_in_rest' => true,
        ];
    }

    /**
     * Default additional arguments that are passed to the render closure.
     *
     * @return array
     */
    protected function getDefaultAdditionalRenderArguments(): array
    {
        return [
            'label_for' => $this->getId(),
        ];
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
        return $this->additionalRenderArguments;
    }

    /**
     * Data used to describe the setting when registered.
     *
     * @return array
     */
    public function getAdditionalSettingArguments(): array
    {
        return $this->additionalSettingsArguments;
    }
}
