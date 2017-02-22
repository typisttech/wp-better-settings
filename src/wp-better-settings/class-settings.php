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

namespace WPBS\WP_Better_Settings;

use ArrayObject;

/**
 * Class Settings.
 *
 * This class registers a settings page via the WordPress Settings API.
 *
 * It enables you an entire collection of settings pages and options fields as
 * as hierarchical text representation in your Config file. In this way, you
 * don't have to deal with all the confusing callback code that the WordPress
 * Settings API forces you to use.
 *
 * @package WPBS\WP_Better_Settings
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class Settings {

	use FunctionInvokerTrait;

	/**
	 * Config instance.
	 *
	 * @since 0.1.0
	 *
	 * @var ArrayObject[];
	 */
	protected $setting_configs;

	/**
	 * Option helper instance.
	 *
	 * @since 0.1.0
	 *
	 * @var Option_Helper_Interface;
	 */
	protected $option_helper;

	/**
	 * Instantiate Settings object.
	 *
	 * @since 0.1.0
	 *
	 * @param ArrayObject[]           $setting_configs Config object that contains
	 *                                                 Settings configuration.
	 * @param Option_Helper_Interface $option_helper   Option helper.
	 */
	public function __construct( array $setting_configs, Option_Helper_Interface $option_helper ) {
		$this->setting_configs = $setting_configs;
		$this->option_helper   = $option_helper;
	}

	/**
	 * Initialize the settings persistence.
	 *
	 * @since 0.1.0
	 */
	public function admin_init() {
		array_walk( $this->setting_configs, [ $this, 'register_setting' ] );
	}

	/**
	 * Register a single setting group
	 *
	 * @since 0.1.0
	 *
	 * @param Setting_Config $settings_config Arguments for the register_setting WP function.
	 *
	 * @throws \InvalidArgumentException If register_setting cannot be invoked.
	 */
	protected function register_setting( Setting_Config $settings_config ) {

		$settings_config->args['default'] = $settings_config->args['default'] ?? $settings_config->default_option();

		$this->invoke_function( 'register_setting', $settings_config );

		// Prepare array to pass to array_walk as third parameter.
		$args                = [];
		$args['option_name'] = $settings_config->option_name;

		array_walk( $settings_config->sections, [ $this, 'add_section' ], $args );
	}

	/**
	 * Add a single options section.
	 *
	 * @since 0.1.0
	 *
	 * @param ArrayObject $data Arguments for the add_settings_section WP function.
	 * @param string      $_key Key of the option section.
	 * @param array       $args Additional arguments to pass on.
	 *
	 * @throws \InvalidArgumentException If add_settings_section cannot be invoked.
	 */
	protected function add_section( ArrayObject $data, string $_key, array $args ) {
		$this->invoke_function( 'add_settings_section', $data );

		// Extend array to pass to array_walk as third parameter.
		$args['page']    = $data->page;
		$args['section'] = $data->id;

		array_walk( $data->fields, [ $this, 'add_field' ], $args );
	}

	/**
	 * Add a single options field.
	 *
	 * @since 0.1.0
	 *
	 * @param ArrayObject $data Arguments for the add_settings_field WP function.
	 * @param string      $_key Key of the settings field.
	 * @param array       $args Contains both page and section name.
	 *
	 * @throws \InvalidArgumentException If add_settings_field cannot be invoked.
	 */
	protected function add_field( ArrayObject $data, string $_key, array $args ) {
		$data->page        = $args['page'];
		$data->section     = $args['section'];
		$data->option_name = $args['option_name'];
		$data->value       = $this->option_helper->get(
			$data->option_name,
			$data->id
		);

		$this->invoke_function( 'add_settings_field', $data );
	}
}
