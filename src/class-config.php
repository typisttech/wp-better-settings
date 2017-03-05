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
 * Class Config.
 *
 * Config details for a settings field.
 *
 * @since 0.1.0
 */
class Config extends ArrayObject {
	/**
	 * Config constructor.
	 *
	 * @since 0.1.0
	 *
	 * @param array $config Custom config array.
	 */
	public function __construct( array $config = [] ) {
		$config = array_replace_recursive( $this->default_config(), $config );

		// Make sure the config entries can be accessed as properties.
		parent::__construct(
			array_filter( $config ), ArrayObject::ARRAY_AS_PROPS
		);
	}

	/**
	 * Default config.
	 *
	 * To be overridden by subclass.
	 *
	 * @since 0.1.0
	 * @return array
	 */
	protected function default_config() : array {
		return [];
	}

	/**
	 * Check whether the Config has a specific key.
	 *
	 * @since 0.1.0
	 *
	 * @param string $key The key to check the existence for.
	 *
	 * @return bool Whether the specified key exists.
	 */
	public function has_key( string $key ) : bool {
		return array_key_exists( $key, (array) $this );
	}

	/**
	 * Get the value of a specific key.
	 *
	 * @since 0.1.0
	 *
	 * @param string $key The key to get the value for.
	 *
	 * @return mixed Value of the requested key.
	 *               Or, null if undefined.
	 */
	public function get_key( string $key ) {
		return $this[ $key ] ?? null;
	}

	/**
	 * Get an array with all the keys.
	 *
	 * @since 0.1.0
	 * @return array Array of config keys.
	 */
	public function get_keys() : array {
		return array_keys( (array) $this );
	}
}
