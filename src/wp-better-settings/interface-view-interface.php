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


/**
 * Interface ViewInterface
 *
 * Accepts a context and renders its content on request.
 *
 * @since 0.2.0
 */
interface ViewInterface {

	/**
	 * Render the associated view.
	 *
	 * @since  0.2.0
	 *
	 * @link   https://github.com/Medium/medium-wordpress-plugin/blob/c31713968990bab5d83db68cf486953ea161a009/lib/medium-view.php
	 *
	 * @param mixed $context Context variables.
	 * @param bool  $return  [Optional] To return or to echo.
	 *
	 * @return string|boolean   Boolean if $return = true, or file is not readable.
	 *                          Otherwise, returns HTML string.
	 */
	public function render( $context, bool $return = true );

	/**
	 * Echo a given view safely.
	 *
	 * @since 0.2.0
	 *
	 * @param mixed $context Context ArrayObject for which to render the view.
	 */
	public function echo_kses( $context );
}
