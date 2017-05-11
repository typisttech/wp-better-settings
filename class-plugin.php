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

use TypistTech\WPBetterSettings\Factories\Fields\CheckboxFactory;
use TypistTech\WPBetterSettings\Factories\Fields\InputFactory;
use TypistTech\WPBetterSettings\Factories\Fields\TextareaFactory;
use TypistTech\WPBetterSettings\Factories\ViewFactory;
use TypistTech\WPBetterSettings\Fields\Checkbox;
use TypistTech\WPBetterSettings\Fields\Email;
use TypistTech\WPBetterSettings\Fields\Text;
use TypistTech\WPBetterSettings\Fields\Textarea;
use TypistTech\WPBetterSettings\Fields\Url;
use TypistTech\WPBetterSettings\Pages\MenuPage;
use TypistTech\WPBetterSettings\Pages\SubmenuPage;
use TypistTech\WPBetterSettings\Views\View;

/**
 * Final class Plugin.
 *
 * This class hooks our plugin into the WordPress life-cycle.
 */
final class Plugin
{
    /**
     * The plugin option store.
     *
     * @var OptionStore
     */
    private $optionStore;

    /**
     * Plugin constructor.
     *
     * @param OptionStore $optionStore The plugin option store.
     */
    public function __construct(OptionStore $optionStore = null)
    {
        $this->optionStore = $optionStore ?? new OptionStore;
    }

    /**
     * Launch the initialization process.
     */
    public function init()
    {
        $pageRegistrar = new PageRegistrar($this->getPages());
        $settingRegistrar = new SettingRegistrar($this->optionStore, ...$this->getSections());

        add_action('admin_menu', [ $pageRegistrar, 'run' ]);
        add_action('admin_init', [ $settingRegistrar, 'run' ]);
    }

    /**
     * Page configs
     *
     * @return (MenuPage|SubmenuPage)[]
     */
    private function getPages(): array
    {
        $simple = new MenuPage(
            'wpbs-simple',
            __('WP Better Settings', 'wp-better-settings')
        );

        $text = new SubmenuPage(
            'wpbs-simple',
            'wpbs-text',
            __('Text', 'wp-better-settings')
        );

        $email = new SubmenuPage(
            'wpbs-simple',
            'wpbs-email',
            __('Email', 'wp-better-settings')
        );

        $url = new SubmenuPage(
            'wpbs-simple',
            'wpbs-url',
            __('Url', 'wp-better-settings')
        );

        $checkbox = new SubmenuPage(
            'wpbs-simple',
            'wpbs-checkbox',
            __('Checkbox', 'wp-better-settings')
        );

        $textarea = new SubmenuPage(
            'wpbs-simple',
            'wpbs-textarea',
            __('Textarea', 'wp-better-settings')
        );

        $basic = new SubmenuPage(
            'wpbs-simple',
            'wpbs-basic-page',
            'Basic Page',
            'Basic Page without Tabs'
        );
        $basic->getDecorator()->setView(
            ViewFactory::build('basic-page')
        );

        $customView = new SubmenuPage(
            'wpbs-simple',
            'wpbs-custom-view',
            __('Custom View', 'wp-better-settings')
        );
        $customView->getDecorator()->setView(
            new View(plugin_dir_path(__FILE__) . 'partials/custom-view.php')
        );

        return [
            $simple,
            $text,
            $email,
            $url,
            $checkbox,
            $textarea,
            $basic,
            $customView,
        ];
    }

    /**
     * Setting configs
     *
     * @return Section[]
     */
    private function getSections(): array
    {
        $simpleSection = new Section(
            'wpbs-simple',
            __('List of Supported Fields with Minimal Config', 'wp-better-settings'),
            new Text('wpbs_simple_text', __('Simple Text', 'wp-better-settings')),
            new Email('wpbs_simple_email', __('Simple Email', 'wp-better-settings')),
            new Url('wpbs_simple_url', __('Simple Url', 'wp-better-settings')),
            new Checkbox('wpbs_simple_checkbox', __('Simple Checkbox', 'wp-better-settings')),
            new Textarea('wpbs_simple_textarea', __('Simple Textarea', 'wp-better-settings'))
        );
        $simpleSection->getDecorator()
                      ->setContent('<p>I am <strong>section content</strong> with <code>html</code> tags.</p>');

        $basicSection = new Section(
            'wpbs-basic-page',
            __('List of Supported Fields with Minimal Config', 'wp-better-settings'),
            new Text('wpbs_basic_text', __('Simple Text', 'wp-better-settings'))
        );

        $inputFactory = new InputFactory($this->optionStore);

        $textDesc = $inputFactory->build(
            'wpbs_text_desc',
            __('With Description', 'wp-better-settings'),
            [
                'type' => 'text',
                'description' => 'I am a <strong>helpful description</strong> with <code>html</code> tags',
            ]
        );

        $textDisabled = $inputFactory->build(
            'wpbs_text_disabled',
            __('Disabled', 'wp-better-settings'),
            [
                'type' => 'text',
                'disabled' => true,
            ]
        );

        $textSmall = $inputFactory->build(
            'wpbs_text_small',
            __("With WordPress' <code>small-text</code> HTML class", 'wp-better-settings'),
            [
                'type' => 'text',
                'htmlClass' => 'small-text',
            ]
        );

        $textSection = new Section(
            'wpbs-text',
            __('Showcase of Different Field Configuration', 'wp-better-settings'),
            new Text('wpbs_text', __('Minimal', 'wp-better-settings')),
            $textDesc,
            $textDisabled,
            $textSmall
        );

        $emailDesc = $inputFactory->build(
            'wpbs_email_desc',
            __('With Description', 'wp-better-settings'),
            [
                'type' => 'email',
                'description' => 'I am a <strong>helpful description</strong> with <code>html</code> tags',
            ]
        );

        $emailDisabled = $inputFactory->build(
            'wpbs_email_disabled',
            __('Disabled', 'wp-better-settings'),
            [
                'type' => 'email',
                'disabled' => true,
            ]
        );

        $emailSmall = $inputFactory->build(
            'wpbs_email_small',
            __("With WordPress' <code>small-text</code> HTML class", 'wp-better-settings'),
            [
                'type' => 'email',
                'htmlClass' => 'small-text',
            ]
        );

        $emailSection = new Section(
            'wpbs-email',
            __('Showcase of Different Field Configuration', 'wp-better-settings'),
            new Email('wpbs_email', __('Minimal', 'wp-better-settings')),
            $emailDesc,
            $emailDisabled,
            $emailSmall
        );

        $urlDesc = $inputFactory->build(
            'wpbs_url_desc',
            __('With Description', 'wp-better-settings'),
            [
                'type' => 'url',
                'description' => 'I am a <strong>helpful description</strong> with <code>html</code> tags',
            ]
        );

        $urlDisabled = $inputFactory->build(
            'wpbs_url_disabled',
            __('Disabled', 'wp-better-settings'),
            [
                'type' => 'url',
                'disabled' => true,
            ]
        );

        $urlSmall = $inputFactory->build(
            'wpbs_url_small',
            __("With WordPress' <code>small-text</code> HTML class", 'wp-better-settings'),
            [
                'type' => 'url',
                'htmlClass' => 'small-text',
            ]
        );

        $urlSection = new Section(
            'wpbs-url',
            __('Showcase of Different Field Configuration', 'wp-better-settings'),
            new Url('wpbs_url', __('Minimal', 'wp-better-settings')),
            $urlDesc,
            $urlDisabled,
            $urlSmall
        );

        $checkboxFactory = new CheckboxFactory($this->optionStore);

        $checkboxDesc = $checkboxFactory->build(
            'wpbs_checkbox_desc',
            __('With Description', 'wp-better-settings'),
            [
                'description' => 'I am a <strong>helpful description</strong> with <code>html</code> tags',
            ]
        );

        $checkboxDisabled = $checkboxFactory->build(
            'wpbs_checkbox_disabled',
            __('Disabled', 'wp-better-settings'),
            [
                'disabled' => true,
            ]
        );

        $checkboxLabel = $checkboxFactory->build(
            'wpbs_checkbox_label',
            __('With Label', 'wp-better-settings'),
            [
                'label' => 'I am a <strong>helpful label</strong> with <code>html</code> tags',
            ]
        );

        $checkboxSection = new Section(
            'wpbs-checkbox',
            __('Showcase of Different Field Configuration', 'wp-better-settings'),
            new Checkbox('wpbs_checkbox', __('Minimal', 'wp-better-settings')),
            $checkboxDesc,
            $checkboxDisabled,
            $checkboxLabel
        );

        $textareaFactory = new TextareaFactory($this->optionStore);

        $textareaDesc = $textareaFactory->build(
            'wpbs_textarea_desc',
            __('With Description', 'wp-better-settings'),
            [
                'description' => 'I am a <strong>helpful description</strong> with <code>html</code> tags',
            ]
        );

        $textareaDisabled = $textareaFactory->build(
            'wpbs_textarea_disabled',
            __('Disabled', 'wp-better-settings'),
            [
                'disabled' => true,
            ]
        );

        $textareaSmall = $textareaFactory->build(
            'wpbs_textarea_small',
            __("With WordPress' <code>small-text</code> HTML class", 'wp-better-settings'),
            [
                'htmlClass' => 'small-text',
            ]
        );

        $textareaRows = $textareaFactory->build(
            'wpbs_textarea_small',
            __("With WordPress' <code>small-text</code> HTML class", 'wp-better-settings'),
            [
                'rows' => 10,
            ]
        );

        $textareaSection = new Section(
            'wpbs-textarea',
            __('Showcase of Different Field Configuration', 'wp-better-settings'),
            new Textarea('wpbs_textarea', __('Minimal', 'wp-better-settings')),
            $textareaDesc,
            $textareaDisabled,
            $textareaSmall,
            $textareaRows
        );

        return [
            $simpleSection,
            $basicSection,
            $textSection,
            $emailSection,
            $urlSection,
            $checkboxSection,
            $textareaSection,
        ];
    }
}
