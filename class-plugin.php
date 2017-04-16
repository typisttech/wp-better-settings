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

use TypistTech\WPBetterSettings\Fields\Checkbox;
use TypistTech\WPBetterSettings\Fields\Email;
use TypistTech\WPBetterSettings\Fields\Text;
use TypistTech\WPBetterSettings\Fields\Textarea;
use TypistTech\WPBetterSettings\Fields\Url;

/**
 * Class Plugin.
 *
 * This class hooks our plugin into the WordPress life-cycle.
 *
 * @since 0.1.0
 */
class Plugin
{
    /**
     * Options store instance.
     *
     * @since 0.1.0
     *
     * @var OptionStoreInterface
     */
    protected $optionStore;

    /**
     * Launch the initialization process.
     *
     * @since 0.1.0
     */
    public function init()
    {
        $this->optionStore = new OptionStore;
        $this->initSettingsPage();
    }

    /**
     * Initialize Settings page.
     */
    public function initSettingsPage()
    {
        $pageRegister = new PageRegister($this->getPages());
        $settings = new SettingRegister($this->settingsConfigs(), $this->optionStore);

        // Register the settings page with WordPress.
        add_action('admin_menu', [ $pageRegister, 'run' ]);
        add_action('admin_init', [ $settings, 'adminInit' ]);
    }

    /**
     * Page configs
     *
     * @return (MenuPage|SubmenuPage)[]
     */
    private function getPages(): array
    {
        return [
            new MenuPage(
                'wpbs-1',
                'WP Better Settings'
            ),
            new SubmenuPage(
                'wpbs-1',
                'wpbs-2',
                'WPBS Two',
                ViewFactory::build('basic-options-page'),
                'WP Better Settings Two'
            ),
        ];
    }

    /**
     * Setting configs
     *
     * @return SettingConfig[]
     */
    private function settingsConfigs(): array
    {
        return [
            new SettingConfig([
                'option_group' => 'wpbs-1',
                'option_name' => 'wpbs_1',
                'sections' => [
                    new SectionConfig([
                        'id' => 'wpbs_section_1',
                        'page' => 'wpbs-1',
                        'title' => __('My Useless Name Settings', 'wp-better-settings'),
                        'desc' => 'Just my section desc',
                        'fields' => [
                            new Text('my_name', __('My Name', 'wp-better-settings'), [
                                'desc' => 'I am a description paragraph',
                            ]),
                            new Email('my_email', __('My Email', 'wp-better-settings')),
                            new Url('my_url', __('My Url', 'wp-better-settings')),
                            new Textarea('my_textarea', __('My Textarea', 'wp-better-settings'), [
                                'rows' => 11,
                            ]),
                            new Checkbox('my_checkbox', __('My Checkbox', 'wp-better-settings'), [
                                'label' => __('Click me', 'wp-better-settings'),
                                'desc' => __('Checkmate', 'wp-better-settings'),
                            ]),
                            new Text('my_disabled_input', __('My Disabled Input', 'wp-better-settings'), [
                                'desc' => 'Disabled on purpose',
                                'disabled' => true,
                            ]),
                            new Textarea('my_disabled_textarea', __('My Disabled Textarea', 'wp-better-settings'), [
                                'desc' => 'You shall not type',
                                'disabled' => true,
                            ]),
                            new Checkbox('my_disabled_checkbox', __('My Disabled Checkbox', 'wp-better-settings'), [
                                'desc' => __('You shall not check', 'wp-better-settings'),
                                'disabled' => true,
                            ]),
                        ],
                    ]),
                ],
            ]),

            new SettingConfig([
                'option_group' => 'wpbs-2',
                'option_name' => 'wpbs_2',
                'sections' => [
                    new SectionConfig([
                        'id' => 'wpbs_section_2',
                        'title' => __('Useless Name Settings', 'wp-better-settings'),
                        'page' => 'wpbs-2',
                        'view' => plugin_dir_path(__FILE__) . 'partials/section-description.php',
                        'fields' => [
                            new Text('wpbs_first_name', __('First Name', 'wp-better-settings')),
                            new Text(
                                'wpbs_last_name',
                                __('Last Name', 'wp-better-settings'),
                                null,
                                null,
                                new View(plugin_dir_path(__FILE__) . 'partials/last-name-field.php')
                            ),
                        ],
                    ]),
                ],
            ]),
        ];
    }
}
