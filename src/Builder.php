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

use AdamWathan\Form\FormBuilder;
use TypistTech\WPOptionStore\OptionStoreInterface;

final class Builder
{
    /**
     * Option store.
     *
     * @var OptionStoreInterface
     */
    private $optionStore;

    /**
     * Form builder.
     *
     * @var FormBuilder
     */
    private $builder;

    /**
     * Builder constructor.
     *
     * @param OptionStoreInterface $optionStore Option store.
     * @param FormBuilder          $builder     Optional. Form builder.
     */
    public function __construct(OptionStoreInterface $optionStore, FormBuilder $builder = null)
    {
        $this->optionStore = $optionStore;
        $this->builder = $builder ?? new FormBuilder();
    }

    /**
     * Build a checkbox field.
     *
     * @param string $id                          String for use in the 'id' attribute of tags.
     * @param string $title                       Title of the field.
     * @param array  $additionalSettingsArguments Optional. Data used to describe the setting when registered.
     * @param array  $additionalRenderArguments   Optional. Extra arguments used when outputting the field.
     *
     * @return Field
     */
    public function checkbox(
        string $id,
        string $title,
        array $additionalSettingsArguments = null,
        array $additionalRenderArguments = null
    ): Field {
        $formControl = $this->builder->checkbox($id)->value('true');
        $this->optionStore->getBoolean($id) ? $formControl->check() : $formControl->uncheck();

        $additionalSettingsArguments = array_merge(
            [
                'type' => 'boolean',
                'sanitize_callback' => function ($value): bool {
                    return 'true' === sanitize_text_field($value);
                },
            ],
            (array) $additionalSettingsArguments
        );

        return new Field(
            $id,
            $title,
            $formControl,
            (array) $additionalSettingsArguments,
            (array) $additionalRenderArguments
        );
    }

    /**
     * Build an email field.
     *
     * @param string $id                          String for use in the 'id' attribute of tags.
     * @param string $title                       Title of the field.
     * @param array  $additionalSettingsArguments Optional. Data used to describe the setting when registered.
     * @param array  $additionalRenderArguments   Optional. Extra arguments used when outputting the field.
     *
     * @return Field
     */
    public function email(
        string $id,
        string $title,
        array $additionalSettingsArguments = null,
        array $additionalRenderArguments = null
    ): Field {
        $formControl = $this->builder->email($id)
                                     ->addClass('regular-text')
                                     ->value(
                                         $this->optionStore->getString($id)
                                     );

        $additionalSettingsArguments = array_merge(
            [
                'sanitize_callback' => 'sanitize_email',
            ],
            (array) $additionalSettingsArguments
        );

        return new Field(
            $id,
            $title,
            $formControl,
            (array) $additionalSettingsArguments,
            (array) $additionalRenderArguments
        );
    }

    /**
     * Build a password field.
     *
     * @param string $id                          String for use in the 'id' attribute of tags.
     * @param string $title                       Title of the field.
     * @param array  $additionalSettingsArguments Optional. Data used to describe the setting when registered.
     * @param array  $additionalRenderArguments   Optional. Extra arguments used when outputting the field.
     *
     * @return Field
     */
    public function password(
        string $id,
        string $title,
        array $additionalSettingsArguments = null,
        array $additionalRenderArguments = null
    ): Field {
        $formControl = $this->builder->password($id)
                                     ->addClass('regular-text')
                                     ->value(
                                         $this->optionStore->getString($id)
                                     );

        return new Field(
            $id,
            $title,
            $formControl,
            (array) $additionalSettingsArguments,
            (array) $additionalRenderArguments
        );
    }

    /**
     * Build a select field.
     *
     * @param string $id                          String for use in the 'id' attribute of tags.
     * @param string $title                       Title of the field.
     * @param array  $options                     Valid options.
     * @param array  $additionalSettingsArguments Optional. Data used to describe the setting when registered.
     * @param array  $additionalRenderArguments   Optional. Extra arguments used when outputting the field.
     *
     * @return Field
     */
    public function select(
        string $id,
        string $title,
        array $options,
        array $additionalSettingsArguments = null,
        array $additionalRenderArguments = null
    ): Field {
        $formControl = $this->builder->select($id, $options)
                                     ->select(
                                         $this->optionStore->getString($id)
                                     );

        $additionalSettingsArguments = array_merge(
            [
                'sanitize_callback' => function ($value) use ($options): string {
                    $value = sanitize_text_field($value);

                    return array_key_exists($value, $options) ? $value : '';
                },
            ],
            (array) $additionalSettingsArguments
        );

        return new Field(
            $id,
            $title,
            $formControl,
            (array) $additionalSettingsArguments,
            (array) $additionalRenderArguments
        );
    }

    /**
     * Build a text field.
     *
     * @param string $id                          String for use in the 'id' attribute of tags.
     * @param string $title                       Title of the field.
     * @param array  $additionalSettingsArguments Optional. Data used to describe the setting when registered.
     * @param array  $additionalRenderArguments   Optional. Extra arguments used when outputting the field.
     *
     * @return Field
     */
    public function text(
        string $id,
        string $title,
        array $additionalSettingsArguments = null,
        array $additionalRenderArguments = null
    ): Field {
        $formControl = $this->builder->text($id)
                                     ->addClass('regular-text')
                                     ->value(
                                         $this->optionStore->getString($id)
                                     );

        return new Field(
            $id,
            $title,
            $formControl,
            (array) $additionalSettingsArguments,
            (array) $additionalRenderArguments
        );
    }

    /**
     * Build a textarea field.
     *
     * @param string $id                          String for use in the 'id' attribute of tags.
     * @param string $title                       Title of the field.
     * @param array  $additionalSettingsArguments Optional. Data used to describe the setting when registered.
     * @param array  $additionalRenderArguments   Optional. Extra arguments used when outputting the field.
     *
     * @return Field
     */
    public function textarea(
        string $id,
        string $title,
        array $additionalSettingsArguments = null,
        array $additionalRenderArguments = null
    ): Field {
        $formControl = $this->builder->textarea($id)
                                     ->addClass('regular-text')
                                     ->value(
                                         $this->optionStore->getString($id)
                                     );

        $additionalSettingsArguments = array_merge(
            [
                'sanitize_callback' => 'sanitize_textarea_field',
            ],
            (array) $additionalSettingsArguments
        );

        return new Field(
            $id,
            $title,
            $formControl,
            (array) $additionalSettingsArguments,
            (array) $additionalRenderArguments
        );
    }

    /**
     * Build a url field.
     *
     * @param string $id                          String for use in the 'id' attribute of tags.
     * @param string $title                       Title of the field.
     * @param array  $additionalSettingsArguments Optional. Data used to describe the setting when registered.
     * @param array  $additionalRenderArguments   Optional. Extra arguments used when outputting the field.
     *
     * @return Field
     */
    public function url(
        string $id,
        string $title,
        array $additionalSettingsArguments = null,
        array $additionalRenderArguments = null
    ): Field {
        $formControl = $this->builder->text($id)
                                     ->type('url')
                                     ->addClass('regular-text')
                                     ->value(
                                         $this->optionStore->getString($id)
                                     );

        $additionalSettingsArguments = array_merge(
            [
                'sanitize_callback' => 'esc_url_raw',
            ],
            (array) $additionalSettingsArguments
        );

        return new Field(
            $id,
            $title,
            $formControl,
            (array) $additionalSettingsArguments,
            (array) $additionalRenderArguments
        );
    }

    /**
     * Build a positive number field.
     *
     * @param string $id                          String for use in the 'id' attribute of tags.
     * @param string $title                       Title of the field.
     * @param array  $additionalSettingsArguments Optional. Data used to describe the setting when registered.
     * @param array  $additionalRenderArguments   Optional. Extra arguments used when outputting the field.
     *
     * @return Field
     */
    public function number(
        string $id,
        string $title,
        array $additionalSettingsArguments = null,
        array $additionalRenderArguments = null
    ): Field {
        $formControl = $this->builder->text($id)
                                     ->type('number')
                                     ->addClass('regular-text')
                                     ->min(0)
                                     ->value(
                                         $this->optionStore->getString($id)
                                     );

        $additionalSettingsArguments = array_merge(
            [
                'sanitize_callback' => 'absint',
            ],
            (array) $additionalSettingsArguments
        );

        return new Field(
            $id,
            $title,
            $formControl,
            (array) $additionalSettingsArguments,
            (array) $additionalRenderArguments
        );
    }
}
