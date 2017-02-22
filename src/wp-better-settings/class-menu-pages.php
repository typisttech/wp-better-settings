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
 * Class Menu_Pages
 *
 * This class registers Menu_Pages via the WordPress API.
 *
 * @since 0.1.0
 *
 * It enables you an entire collection of menu pages as as hierarchical
 * representation in your Menu_Page_Config objects. In this way, you
 * don't have to deal with all the confusing callback code that the
 * WordPress Settings API forces you to use.
 */
class Menu_Pages {

	use Function_Invoker_Trait;

	/**
	 * Array of Config instance.
	 *
	 * @since 0.1.0
	 *
	 * @var ArrayObject[];
	 */
	protected $configs;

	/**
	 * Menu_Pages constructor.
	 *
	 * @since 0.1.0
	 *
	 * @param ArrayObject[] $configs Array of config objects that contains
	 *                               menu page configurations.
	 */
	public function __construct( array $configs ) {
		$this->configs = $configs;
	}

	/**
	 * Add the pages from the configuration objects to the WordPress admin
	 * backend.
	 *
	 * @since 0.1.0
	 */
	public function admin_menu() {
		array_walk( $this->configs, [ $this, 'add_menu_page' ] );
	}

	/**
	 * Add a single page to the WordPress admin backend.
	 *
	 * @since 0.1.0
	 *
	 * @param ArrayObject $menu_page_config Arguments for the menu page creation function.
	 *
	 * @throws \InvalidArgumentException If the function cannot be invoked.
	 */
	protected function add_menu_page( ArrayObject $menu_page_config ) {
		$menu_page_config->tabs = $this->configs;
		$this->invoke_function( $menu_page_config->function_name, $menu_page_config );
	}
}
