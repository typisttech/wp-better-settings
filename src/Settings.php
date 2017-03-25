<?php
/**
 * WP Better Settings
 *
 * A simplified OOP implementation of the WP Settings API.
 *
 * @package TypistTech\WPBetterSettings
 * @author Typist Tech <wp-better-settings@typist.tech>
 * @copyright 2017 Typist Tech
 * @license GPL-2.0+
 * @see https://www.typist.tech/projects/wp-better-settings
 * @see https://github.com/TypistTech/wp-better-settings
 */

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

use ArrayObject;

/**
 * Class Settings.
 *
 * This class registers settings via the WordPress Settings API.
 *
 * It enables you an entire collection of settings pages and options fields as
 * as hierarchical text representation in your Config file. In this way, you
 * don't have to deal with all the confusing callback code that the WordPress
 * Settings API forces you to use.
 *
 * @since 0.1.0
 */
class Settings
{
    use FunctionInvokerTrait;

    /**
     * Option helper instance.
     *
     * @since 0.1.0
     * @var OptionStoreInterface;
     */
    protected $optionHelper;

    /**
     * Config instance.
     *
     * @since 0.1.0
     * @var ArrayObject[];
     */
    protected $settingConfigs;

    /**
     * Instantiate Settings object.
     *
     * @since 0.1.0
     *
     * @param ArrayObject[]        $settingConfigs     Config object that contains
     *                                                 Settings configuration.
     * @param OptionStoreInterface $optionHelper       Option helper.
     */
    public function __construct(array $settingConfigs, OptionStoreInterface $optionHelper)
    {
        $this->settingConfigs = $settingConfigs;
        $this->optionHelper   = $optionHelper;
    }

    /**
     * Initialize the settings persistence.
     *
     * @since 0.1.0
     * @return void
     */
    public function adminInit()
    {
        array_walk($this->settingConfigs, [ $this, 'registerSetting' ]);
    }

    /**
     * Add a single settings field.
     *
     * @since 0.1.0
     *
     * @param ArrayObject $field_config Arguments for the add_settings_field WP function.
     * @param string      $_key         [Unused] Key of the settings field.
     * @param array       $args         Contains both page and section name.
     *
     * @return void
     * @throws \InvalidArgumentException If add_settings_field cannot be invoked.
     */
    protected function addField(ArrayObject $field_config, string $_key, array $args)
    {
        $field_config->page        = $args['page'];
        $field_config->section     = $args['section'];
        $field_config->option_name = $args['option_name'];
        $field_config->value       = $this->optionHelper->get(
            $field_config->option_name,
            $field_config->id
        );

        $this->invokeFunction('add_settings_field', $field_config);
    }

    /**
     * Add a single settings section.
     *
     * @since 0.1.0
     *
     * @param ArrayObject $sectionConfig Arguments for the add_settings_section WP function.
     * @param string      $_key          [Unused] Key of the settings section.
     * @param array       $args          Additional arguments to pass on.
     *
     * @return void
     * @throws \InvalidArgumentException If add_settings_section cannot be invoked.
     */
    protected function addSection(ArrayObject $sectionConfig, string $_key, array $args)
    {
        $this->invokeFunction('add_settings_section', $sectionConfig);

        // Extend array to pass to array_walk as third parameter.
        $args['page']    = $sectionConfig->page;
        $args['section'] = $sectionConfig->id;

        array_walk($sectionConfig->fields, [ $this, 'addField' ], $args);
    }

    /**
     * Register a single setting group.
     *
     * @since 0.1.0
     *
     * @param ArrayObject $setting_config Arguments for the register_setting WP function.
     *
     * @return void
     * @throws \InvalidArgumentException If register_setting cannot be invoked.
     */
    protected function registerSetting(ArrayObject $setting_config)
    {
        $this->invokeFunction('register_setting', $setting_config);

        // Prepare array to pass to array_walk as third parameter.
        $args                = [];
        $args['option_name'] = $setting_config->option_name;

        array_walk($setting_config->sections, [ $this, 'addSection' ], $args);
    }
}