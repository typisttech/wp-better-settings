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
        $settings = new Settings($this->settingsConfigs(), $this->optionStore);

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
     * @since 0.3.0
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
                            new FieldConfig([
                                'id' => 'my_name',
                                'title' => __('My Name', 'wp-better-settings'),
                                'default' => 'Tang Rufus',
                                'view' => ViewFactory::build('text-field'),
                                'desc' => 'I am a description paragraph',
                            ]),
                            new FieldConfig([
                                'id' => 'my_email',
                                'title' => __('My Email', 'wp-better-settings'),
                                'view' => ViewFactory::build('email-field'),
                                'sanitize_callback' => [ Sanitizer::class, 'sanitize_email' ],
                            ]),
                            new FieldConfig([
                                'id' => 'my_url',
                                'title' => __('My Url', 'wp-better-settings'),
                                'default' => 'https://www.typist.tech',
                                'view' => ViewFactory::build('url-field'),
                                'sanitize_callback' => 'esc_url_raw',
                            ]),
                            new FieldConfig([
                                'id' => 'my_textarea',
                                'title' => __('My Textarea', 'wp-better-settings'),
                                'view' => ViewFactory::build('textarea-field'),
                                'rows' => 11,
                            ]),
                            new FieldConfig([
                                'id' => 'my_checkbox',
                                'title' => __('My Checkbox', 'wp-better-settings'),
                                'view' => ViewFactory::build('checkbox-field'),
                                'label' => __('Click me', 'wp-better-settings'),
                                'desc' => __('Checkmate', 'wp-better-settings'),
                                'sanitize_callback' => [ Sanitizer::class, 'sanitize_checkbox' ],
                            ]),
                            new FieldConfig([
                                'id' => 'my_disabled_input',
                                'title' => __('My Disabled Input', 'wp-better-settings'),
                                'desc' => 'Disabled on purpose',
                                'view' => ViewFactory::build('text-field'),
                                'disabled' => true,
                            ]),
                            new FieldConfig([
                                'id' => 'my_disabled_textarea',
                                'title' => __('My Disabled Textarea', 'wp-better-settings'),
                                'view' => ViewFactory::build('textarea-field'),
                                'desc' => 'You shall not type',
                                'disabled' => true,
                            ]),
                            new FieldConfig([
                                'id' => 'my_disabled_checkbox',
                                'title' => __('My Disabled Checkbox', 'wp-better-settings'),
                                'view' => ViewFactory::build('checkbox-field'),
                                'desc' => __('You shall not check', 'wp-better-settings'),
                                'disabled' => true,
                                'sanitize_callback' => [ Sanitizer::class, 'sanitize_checkbox' ],
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
                            new FieldConfig([
                                'id' => 'wpbs_first_name',
                                'title' => __('First Name', 'wp-better-settings'),
                                'view' => ViewFactory::build('text-field'),
                                'default' => 'Elliot',
                            ]),
                            new FieldConfig([
                                'id' => 'wpbs_last_name',
                                'title' => __('Last Name', 'wp-better-settings'),
                                'view' => plugin_dir_path(__FILE__) . 'partials/last-name-field.php',
                            ]),
                        ],
                    ]),
                ],
            ]),
        ];
    }
}
