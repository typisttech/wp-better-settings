<?php
/**
 * WP Better Settings
 *
 * A simplified OOP implementation of the WP Settings API.
 *
 * @package   WPBS\WP_Better_Settings
 * @author    Typist Tech <wp-better-settings@typist.tech>
 * @license   GPL-2.0+
 * @link      https://www.typist.tech/
 * @copyright 2017 Typist Tech
 */

namespace WPBS;

use WPBS\WP_Better_Settings\{
	Field_Config, MenuPageConfig, MenuPages, Option_Helper, Sanitizer, SectionConfig, SettingConfig, Settings, ViewFactory
};

/**
 * Class Plugin.
 *
 * This class hooks our plugin into the WordPress life-cycle.
 *
 * @since 0.1.0
 */
class Plugin {
	/**
	 * Options store instance.
	 *
	 * @since 0.1.0
	 *
	 * @var WP_Better_Settings\Option_Helper_Interface
	 */
	protected $options_store;

	/**
	 * Launch the initialization process.
	 *
	 * @since 0.1.0
	 */
	public function init() {
		$this->options_store = new Option_Helper;
		$this->init_settings_page();
	}

	/**
	 * Initialize Settings page.
	 *
	 * @since 0.1.0
	 */
	public function init_settings_page() {
		$menu_pages = new MenuPages( $this->page_configs() );
		$settings   = new Settings( $this->settings_configs(), $this->options_store );

		// Register the settings page with WordPress.
		add_action( 'admin_menu', [ $menu_pages, 'admin_menu' ] );
		add_action( 'admin_init', [ $settings, 'admin_init' ] );
	}

	/**
	 * Page configs
	 *
	 * #since 0.3.0
	 *
	 * @return WP_Better_Settings\MenuPageConfig[]
	 */
	private function page_configs() : array {
		return [
			new MenuPageConfig( [
				'menu_slug'    => 'wpbs_1',
				'page_title'   => 'WP Better Settings',
				'menu_title'   => 'WP Better Settings',
				'option_group' => 'wpbs_1',
				'view'         => ViewFactory::build( 'tabbed-options-page' ),
			] ),
			new MenuPageConfig( [
				'menu_slug'    => 'wpbs_2',
				'page_title'   => 'WP Better Settings Two',
				'menu_title'   => 'WPBS Two',
				'option_group' => 'wpbs_2',
				'parent_slug'  => 'wpbs_1',
				'view'         => ViewFactory::build( 'basic-options-page' ),
			] ),
		];
	}

	/**
	 * Setting configs
	 *
	 * @since 0.3.0
	 *
	 * @return WP_Better_Settings\SettingConfig[]
	 */
	private function settings_configs() : array {
		return [
			new SettingConfig( [
				'option_group' => 'wpbs_1',
				'option_name'  => 'wpbs_option_1',
				'sections'     => [
					new SectionConfig( [
						'id'     => 'wpbs_section_1',
						'page'   => 'wpbs_1',
						'title'  => __( 'My Useless Name Settings', 'as-settings-better-v1' ),
						'desc'   => 'Just my section desc',
						'fields' => [
							new Field_Config( [
								'id'      => 'my_name',
								'title'   => __( 'My Name', 'as-settings-better-v1' ),
								'default' => 'Tang Rufus',
								'view'    => ViewFactory::build( 'text-field' ),
								'desc'    => 'I am a description paragraph',
							] ),
							new Field_Config( [
								'id'                => 'my_email',
								'title'             => __( 'My Email', 'as-settings-better-v1' ),
								'view'              => ViewFactory::build( 'email-field' ),
								'sanitize_callback' => [ Sanitizer::class, 'sanitize_email' ],
							] ),
							new Field_Config( [
								'id'                => 'my_url',
								'title'             => __( 'My Url', 'as-settings-better-v1' ),
								'default'           => 'https://www.typist.tech',
								'view'              => ViewFactory::build( 'url-field' ),
								'sanitize_callback' => 'esc_url_raw',
							] ),
							new Field_Config( [
								'id'    => 'my_textarea',
								'title' => __( 'My Textarea', 'wp-better-settings' ),
								'view'  => ViewFactory::build( 'textarea-field' ),
								'rows'  => 11,
							] ),
							new Field_Config( [
								'id'                => 'my_checkbox',
								'title'             => __( 'My Checkbox', 'wp-better-settings' ),
								'view'              => ViewFactory::build( 'checkbox-field' ),
								'label'             => __( 'Click me', 'wp-cloudflare-guard' ),
								'desc'              => __( 'Checkmate', 'wp-cloudflare-guard' ),
								'sanitize_callback' => [ Sanitizer::class, 'sanitize_checkbox' ],
							] ),
							new Field_Config( [
								'id'       => 'my_disabled_input',
								'title'    => __( 'My Disabled Input', 'as-settings-better-v1' ),
								'desc'     => 'Disabled on purpose',
								'view'     => ViewFactory::build( 'text-field' ),
								'disabled' => true,
							] ),
							new Field_Config( [
								'id'       => 'my_disabled_textarea',
								'title'    => __( 'My Disabled Textarea', 'wp-better-settings' ),
								'view'     => ViewFactory::build( 'textarea-field' ),
								'desc'     => 'You shall not type',
								'disabled' => true,
							] ),
							new Field_Config( [
								'id'                => 'my_disabled_checkbox',
								'title'             => __( 'My Disabled Checkbox', 'wp-better-settings' ),
								'view'              => ViewFactory::build( 'checkbox-field' ),
								'desc'              => __( 'You shall not check', 'wp-cloudflare-guard' ),
								'disabled'          => true,
								'sanitize_callback' => [ Sanitizer::class, 'sanitize_checkbox' ],
							] ),
						],
					] ),
				],
			] ),

			new SettingConfig( [
				'option_group' => 'wpbs_2',
				'option_name'  => 'wpbs_option_2',
				'sections'     => [
					new SectionConfig( [
						'id'     => 'wpbs_section_2',
						'title'  => __( 'Useless Name Settings', 'as-settings-better-v1' ),
						'page'   => 'wpbs_2',
						'view'   => plugin_dir_path( __FILE__ ) . 'partials/section-description.phtml',
						'fields' => [
							new Field_Config( [
								'id'      => 'wpbs_first_name',
								'title'   => __( 'First Name', 'as-settings-better-v1' ),
								'view'    => ViewFactory::build( 'text-field' ),
								'default' => 'Elliot',
							] ),
							new Field_Config( [
								'id'    => 'wpbs_last_name',
								'title' => __( 'Last Name', 'as-settings-better-v1' ),
								'view'  => plugin_dir_path( __FILE__ ) . 'partials/last-name-field.phtml',
							] ),
						],
					] ),
				],
			] ),
		];
	}
}
