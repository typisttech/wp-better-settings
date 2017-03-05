<?php
/**
 * WP Better Settings
 *
 * A simplified OOP implementation of the WP Settings API.
 *
 * @package   WP_Better_Settings
 * @author    Typist Tech <wp-better-settings@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   GPL-2.0+
 * @see       https://www.typist.tech/projects/wp-better-settings
 * @see       https://github.com/TypistTech/wp-better-settings
 */

namespace WP_Better_Settings;

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
	 * @var Option_Store_Interface
	 */
	protected $options_store;

	/**
	 * Launch the initialization process.
	 *
	 * @since 0.1.0
	 */
	public function init() {
		$this->options_store = new Option_Store;
		$this->init_settings_page();
	}

	/**
	 * Initialize Settings page.
	 *
	 * @since 0.1.0
	 */
	public function init_settings_page() {
		$menu_pages = new Menu_Pages( $this->page_configs() );
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
	 * @return Menu_Page_Config[]
	 */
	private function page_configs() : array {
		return [
			new Menu_Page_Config( [
				'menu_slug'    => 'wpbs_1',
				'page_title'   => 'WP Better Settings',
				'menu_title'   => 'WP Better Settings',
				'option_group' => 'wpbs_1',
			] ),
			new Menu_Page_Config( [
				'menu_slug'    => 'wpbs_2',
				'page_title'   => 'WP Better Settings Two',
				'menu_title'   => 'WPBS Two',
				'option_group' => 'wpbs_2',
				'parent_slug'  => 'wpbs_1',
				'view'         => View_Factory::build( 'basic-options-page' ),
			] ),
		];
	}

	/**
	 * Setting configs
	 *
	 * @since 0.3.0
	 *
	 * @return Setting_Config[]
	 */
	private function settings_configs() : array {
		return [
			new Setting_Config( [
				'option_group' => 'wpbs_1',
				'option_name'  => 'wpbs_option_1',
				'sections'     => [
					new Section_Config( [
						'id'     => 'wpbs_section_1',
						'page'   => 'wpbs_1',
						'title'  => __( 'My Useless Name Settings', 'as-settings-better-v1' ),
						'desc'   => 'Just my section desc',
						'fields' => [
							new Field_Config( [
								'id'      => 'my_name',
								'title'   => __( 'My Name', 'as-settings-better-v1' ),
								'default' => 'Tang Rufus',
								'view'    => View_Factory::build( 'text-field' ),
								'desc'    => 'I am a description paragraph',
							] ),
							new Field_Config( [
								'id'                => 'my_email',
								'title'             => __( 'My Email', 'as-settings-better-v1' ),
								'view'              => View_Factory::build( 'email-field' ),
								'sanitize_callback' => [ Sanitizer::class, 'sanitize_email' ],
							] ),
							new Field_Config( [
								'id'                => 'my_url',
								'title'             => __( 'My Url', 'as-settings-better-v1' ),
								'default'           => 'https://www.typist.tech',
								'view'              => View_Factory::build( 'url-field' ),
								'sanitize_callback' => 'esc_url_raw',
							] ),
							new Field_Config( [
								'id'    => 'my_textarea',
								'title' => __( 'My Textarea', 'wp-better-settings' ),
								'view'  => View_Factory::build( 'textarea-field' ),
								'rows'  => 11,
							] ),
							new Field_Config( [
								'id'                => 'my_checkbox',
								'title'             => __( 'My Checkbox', 'wp-better-settings' ),
								'view'              => View_Factory::build( 'checkbox-field' ),
								'label'             => __( 'Click me', 'wp-cloudflare-guard' ),
								'desc'              => __( 'Checkmate', 'wp-cloudflare-guard' ),
								'sanitize_callback' => [ Sanitizer::class, 'sanitize_checkbox' ],
							] ),
							new Field_Config( [
								'id'       => 'my_disabled_input',
								'title'    => __( 'My Disabled Input', 'as-settings-better-v1' ),
								'desc'     => 'Disabled on purpose',
								'view'     => View_Factory::build( 'text-field' ),
								'disabled' => true,
							] ),
							new Field_Config( [
								'id'       => 'my_disabled_textarea',
								'title'    => __( 'My Disabled Textarea', 'wp-better-settings' ),
								'view'     => View_Factory::build( 'textarea-field' ),
								'desc'     => 'You shall not type',
								'disabled' => true,
							] ),
							new Field_Config( [
								'id'                => 'my_disabled_checkbox',
								'title'             => __( 'My Disabled Checkbox', 'wp-better-settings' ),
								'view'              => View_Factory::build( 'checkbox-field' ),
								'desc'              => __( 'You shall not check', 'wp-cloudflare-guard' ),
								'disabled'          => true,
								'sanitize_callback' => [ Sanitizer::class, 'sanitize_checkbox' ],
							] ),
						],
					] ),
				],
			] ),

			new Setting_Config( [
				'option_group' => 'wpbs_2',
				'option_name'  => 'wpbs_option_2',
				'sections'     => [
					new Section_Config( [
						'id'     => 'wpbs_section_2',
						'title'  => __( 'Useless Name Settings', 'as-settings-better-v1' ),
						'page'   => 'wpbs_2',
						'view'   => plugin_dir_path( __FILE__ ) . 'partials/section-description.php',
						'fields' => [
							new Field_Config( [
								'id'      => 'wpbs_first_name',
								'title'   => __( 'First Name', 'as-settings-better-v1' ),
								'view'    => View_Factory::build( 'text-field' ),
								'default' => 'Elliot',
							] ),
							new Field_Config( [
								'id'    => 'wpbs_last_name',
								'title' => __( 'Last Name', 'as-settings-better-v1' ),
								'view'  => plugin_dir_path( __FILE__ ) . 'partials/last-name-field.php',
							] ),
						],
					] ),
				],
			] ),
		];
	}
}
