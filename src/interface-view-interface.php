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


/**
 * Interface View_Interface
 *
 * Accepts a context and echo its content on request.
 *
 * @since 0.2.0
 */
interface View_Interface {

	/**
	 * Echo a given view safely.
	 *
	 * @since 0.2.0
	 *
	 * @param mixed $context Context ArrayObject for which to render the view.
	 *
	 * @return void
	 */
	public function echo_kses( $context );
}
