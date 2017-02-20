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
	FieldConfig, MenuPageConfig, MenuPages, OptionsStore, OptionsStoreInterface, Sanitizer, SectionConfig, SettingConfig, Settings, ViewFactory
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
	 * @var WP_Better_Settings\OptionsStoreInterface
	 */
	protected $options_store;

	/**
	 * Launch the initialization process.
	 *
	 * @since 0.1.0
	 */
	public function init() {
		$this->options_store = new OptionsStore;
		$this->init_settings_page();
	}

	/**
	 * Initialize Settings page.
	 *
	 * @since 0.1.0
	 * @throws \InvalidArgumentException If invalid arguments are passed on.
	 */
	public function init_settings_page() {
		$menu_pages = new MenuPages( [ $this->page_config() ] );
		$settings   = new Settings( [ $this->settings_config() ], $this->options_store );

		// Register the settings page with WordPress.
		add_action( 'admin_menu', [ $menu_pages, 'admin_menu' ] );
		add_action( 'admin_init', [ $settings, 'admin_init' ] );
	}

	/**
	 * Page config
	 *
	 * #since 0.1.0
	 *
	 * @return WP_Better_Settings\MenuPageConfig
	 */
	private function page_config() : MenuPageConfig {
		return new MenuPageConfig( [
			'menu_slug'    => 'assb1_settings_2',
			'page_title'   => 'as-settings-better-v1',
			'menu_title'   => 'as-settings-better-v1',
			'option_group' => 'assb1_settings_2',
			'parent_slug'  => 'options-general.php',
		] );
	}

	/**
	 * Setting config
	 *
	 * @since 0.1.0
	 *
	 * @return WP_Better_Settings\SettingConfig
	 * @throws \InvalidArgumentException If invalid arguments are passed on.
	 */
	private function settings_config() : SettingConfig {
		return new SettingConfig( [
			'option_group' => 'assb1_settings_2',
			'option_name'  => 'my_option_name',
			'sections'     => [
				new SectionConfig( [
					'id'     => 'assb1_settings_section',
					'title'  => __( 'Useless Name Settings', 'as-settings-better-v1' ),
					'page'   => 'assb1_settings_2',
					'view'   => plugin_dir_path( __FILE__ ) . 'partials/section-description.phtml',
					'fields' => [
						new FieldConfig( [
							'id'      => 'assb1_text_field_first_name',
							'title'   => __( 'First Name', 'as-settings-better-v1' ),
							'view'    => ViewFactory::build( 'text-field' ),
							'default' => 'Elliot',
						] ),
						new FieldConfig( [
							'id'    => 'assb1_text_field_last_name',
							'title' => __( 'Last Name', 'as-settings-better-v1' ),
							'view'  => plugin_dir_path( __FILE__ ) . 'partials/last-name-field.phtml',
						] ),
					],
				] ),

				new SectionConfig( [
					'id'     => 'my_settings_section',
					'page'   => 'assb1_settings_2',
					'title'  => __( 'My Useless Name Settings', 'as-settings-better-v1' ),
					'desc'   => 'Just my section desc',
					'fields' => [
						new FieldConfig( [
							'id'                => 'my_name',
							'title'             => __( 'My Name', 'as-settings-better-v1' ),
							'default'           => 'Tang Rufus',
							'view'              => ViewFactory::build( 'text-field' ),
							'sanitize_callback' => 'sanitize_text_field',
						] ),
						new FieldConfig( [
							'id'                => 'my_email',
							'title'             => __( 'My Email', 'as-settings-better-v1' ),
							'view'              => ViewFactory::build( 'email-field' ),
							'sanitize_callback' => [ Sanitizer::class, 'sanitize_email' ],
						] ),
						new FieldConfig( [
							'id'                => 'my_url',
							'title'             => __( 'My Url', 'as-settings-better-v1' ),
							'default'           => 'https://www.typist.tech',
							'view'              => ViewFactory::build( 'url-field' ),
							'sanitize_callback' => 'esc_url_raw',
						] ),
						new FieldConfig( [
							'id'                => 'my_disabled_input',
							'title'             => __( 'My Disabled Input', 'as-settings-better-v1' ),
							'default'           => 'Disabled on purpose',
							'view'              => ViewFactory::build( 'text-field' ),
							'disabled'          => true,
						] ),
					],
				] ),
			],
		] );
	}
}
