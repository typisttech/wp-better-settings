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

namespace WP_Better_Settings;

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
class Settings {

	use Function_Invoker_Trait;

	/**
	 * Config instance.
	 *
	 * @since 0.1.0
	 * @var ArrayObject[];
	 */
	protected $setting_configs;

	/**
	 * Option helper instance.
	 *
	 * @since 0.1.0
	 * @var Option_Store_Interface;
	 */
	protected $option_helper;

	/**
	 * Instantiate Settings object.
	 *
	 * @since 0.1.0
	 *
	 * @param ArrayObject[]          $setting_configs  Config object that contains
	 *                                                 Settings configuration.
	 * @param Option_Store_Interface $option_helper    Option helper.
	 */
	public function __construct( array $setting_configs, Option_Store_Interface $option_helper ) {
		$this->setting_configs = $setting_configs;
		$this->option_helper   = $option_helper;
	}

	/**
	 * Initialize the settings persistence.
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function admin_init() {
		array_walk( $this->setting_configs, [ $this, 'register_setting' ] );
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
	protected function register_setting( ArrayObject $setting_config ) {
		$this->invoke_function( 'register_setting', $setting_config );

		// Prepare array to pass to array_walk as third parameter.
		$args                = [];
		$args['option_name'] = $setting_config->option_name;

		array_walk( $setting_config->sections, [ $this, 'add_section' ], $args );
	}

	/**
	 * Add a single settings section.
	 *
	 * @since 0.1.0
	 *
	 * @param ArrayObject $section_config Arguments for the add_settings_section WP function.
	 * @param string      $_key           [Unused] Key of the settings section.
	 * @param array       $args           Additional arguments to pass on.
	 *
	 * @return void
	 * @throws \InvalidArgumentException If add_settings_section cannot be invoked.
	 */
	protected function add_section( ArrayObject $section_config, string $_key, array $args ) {
		$this->invoke_function( 'add_settings_section', $section_config );

		// Extend array to pass to array_walk as third parameter.
		$args['page']    = $section_config->page;
		$args['section'] = $section_config->id;

		array_walk( $section_config->fields, [ $this, 'add_field' ], $args );
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
	protected function add_field( ArrayObject $field_config, string $_key, array $args ) {
		$field_config->page        = $args['page'];
		$field_config->section     = $args['section'];
		$field_config->option_name = $args['option_name'];
		$field_config->value       = $this->option_helper->get(
			$field_config->option_name,
			$field_config->id
		);

		$this->invoke_function( 'add_settings_field', $field_config );
	}
}
