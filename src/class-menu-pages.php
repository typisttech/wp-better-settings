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

use ArrayObject;

/**
 * Class Menu_Pages.
 *
 * This class registers menu pages via the WordPress API.
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
	protected $menu_page_configs;

	/**
	 * Menu_Pages constructor.
	 *
	 * @since 0.1.0
	 *
	 * @param ArrayObject[] $menu_page_configs Array of config objects that contains
	 *                                         menu page configurations.
	 */
	public function __construct( array $menu_page_configs ) {
		$this->menu_page_configs = $menu_page_configs;
	}

	/**
	 * Add the pages from the configuration objects to the WordPress admin
	 * backend. Parent pages are invoked first.
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function admin_menu() {
		// Parent pages must be added before submenu pages.
		usort( $this->menu_page_configs, [ $this, 'compare_parent_slug' ] );
		array_walk( $this->menu_page_configs, [ $this, 'add_menu_page' ] );
	}

	/**
	 * Add a single page to the WordPress admin backend.
	 *
	 * @since 0.1.0
	 *
	 * @param ArrayObject $menu_page_config Arguments for the menu page creation function.
	 *
	 * @return void
	 * @throws \InvalidArgumentException If the function cannot be invoked.
	 */
	protected function add_menu_page( ArrayObject $menu_page_config ) {
		$menu_page_config->tabs = $this->menu_page_configs;
		$this->invoke_function( $menu_page_config->function_name, $menu_page_config );
	}

	/**
	 * Compare two ArrayObject by their parent_slug.
	 *
	 * @since  0.5.1
	 * @access private
	 *
	 * @param ArrayObject $first The first to be compared.
	 * @param ArrayObject $other The other to be compared.
	 *
	 * @return int
	 */
	private function compare_parent_slug( ArrayObject $first, ArrayObject $other ) : int {
		$first_parent_slug = $first['parent_slug'] ?? null;
		$other_parent_slug = $other['parent_slug'] ?? null;

		return strcmp( $first_parent_slug, $other_parent_slug );
	}
}
