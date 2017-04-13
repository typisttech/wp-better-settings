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
 */
class Settings
{
    use FunctionInvokerTrait;

    /**
     * Option helper instance.
     *
     * @var OptionStoreInterface;
     */
    protected $optionHelper;

    /**
     * Config instance.
     *
     * @var ArrayObject[];
     */
    protected $settingConfigs;

    /**
     * Instantiate Settings object.
     *
     * @param ArrayObject[]        $settingConfigs Config object that contains
     *                                             Settings configuration.
     * @param OptionStoreInterface $optionHelper   Option helper.
     */
    public function __construct(array $settingConfigs, OptionStoreInterface $optionHelper)
    {
        $this->settingConfigs = $settingConfigs;
        $this->optionHelper = $optionHelper;
    }

    /**
     * Initialize the settings persistence.
     *
     * @return void
     */
    public function adminInit()
    {
        array_walk($this->settingConfigs, [ $this, 'registerSetting' ]);
    }

    /**
     * Add a single settings field.
     *
     * @param ArrayObject $fieldConfig Arguments for the add_settings_field WP function.
     * @param string      $key         [Unused] Key of the settings field.
     * @param array       $args        Contains both page and section name.
     *
     * @throws \InvalidArgumentException If add_settings_field cannot be invoked.
     *
     * @return void
     */
    protected function addField(ArrayObject $fieldConfig, string $key, array $args)
    {
        $fieldConfig->page = $args['page'];
        $fieldConfig->section = $args['section'];
        $fieldConfig->option_name = $args['option_name'];
        $fieldConfig->value = $this->optionHelper->get(
            $fieldConfig->option_name,
            $fieldConfig->id
        );

        $this->invokeFunction('add_settings_field', $fieldConfig);
    }

    /**
     * Add a single settings section.
     *
     * @param ArrayObject $sectionConfig Arguments for the add_settings_section WP function.
     * @param string      $key           [Unused] Key of the settings section.
     * @param array       $args          Additional arguments to pass on.
     *
     * @throws \InvalidArgumentException If add_settings_section cannot be invoked.
     *
     * @return void
     */
    protected function addSection(ArrayObject $sectionConfig, string $key, array $args)
    {
        $this->invokeFunction('add_settings_section', $sectionConfig);

        // Extend array to pass to array_walk as third parameter.
        $args['page'] = $sectionConfig->page;
        $args['section'] = $sectionConfig->id;

        array_walk($sectionConfig->fields, [ $this, 'addField' ], $args);
    }

    /**
     * Register a single setting group.
     *
     * @param ArrayObject $settingConfig Arguments for the register_setting WP function.
     *
     * @throws \InvalidArgumentException If register_setting cannot be invoked.
     *
     * @return void
     */
    protected function registerSetting(ArrayObject $settingConfig)
    {
        $this->invokeFunction('register_setting', $settingConfig);

        // Prepare array to pass to array_walk as third parameter.
        $args = [];
        $args['option_name'] = $settingConfig->option_name;

        array_walk($settingConfig->sections, [ $this, 'addSection' ], $args);
    }
}
