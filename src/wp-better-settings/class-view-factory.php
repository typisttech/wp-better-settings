<?php
/**
 * WP Better Settings
 *
 * A simplified OOP implementation of the WP Settings API
 *
 * @package   WPBS\WP_Better_Settings
 * @author    Typist Tech <wp-better-settings@typist.tech>
 * @license   GPL-2.0+
 * @link      https://www.typist.tech/
 * @copyright 2017 Typist Tech
 */

namespace WPBS\WP_Better_Settings;

use InvalidArgumentException;

/**
 * Class ViewFactory
 *
 * Factory for View objects.
 *
 * @since 0.1.0
 */
class ViewFactory {

	/**
	 * Relative path to built-in view partials.
	 *
	 * @since 0.1.0
	 *
	 * @var array
	 */
	const PARTIALS = [
		'basic-options-page'  => 'partials/basic-options-page.phtml',
		'section-description' => 'partials/section-description.phtml',
		'email-field'         => 'partials/email-field.phtml',
		'text-field'          => 'partials/text-field.phtml',
		'url-field'           => 'partials/url-field.phtml',
	];

	/**
	 * Built a View object for one of the built-in field types.
	 *
	 * @since 0.1.0
	 *
	 * @param string $type Type of the partial. Must be one of
	 *                     the built-in partial.
	 *
	 * @return View        View object for the partial.
	 *
	 * @throws InvalidArgumentException    If the partial is not supported.
	 */
	public static function build( string $type ) : View {
		if ( ! array_key_exists( $type, self::PARTIALS ) ) {
			throw new InvalidArgumentException(
				sprintf(
					'%1$s: Partial for "%2$s" not found. Build-in partials include "%3$s".',
					__CLASS__,
					$type,
					implode( ', ', array_keys( self::PARTIALS ) )
				)
			);
		}

		return new View(
			plugin_dir_path( __FILE__ ) . self::PARTIALS[ $type ]
		);
	}
}
