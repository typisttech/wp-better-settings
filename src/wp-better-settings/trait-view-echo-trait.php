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

/**
 * Trait View_Echo_Trait.
 *
 * Reusable trait that you can use in any ArrayObject
 * which has a View_Interface or String as view property.
 *
 * @since 0.5.1
 * @property View_Interface|string $view View_Interface object to render.
 *                                       Or, string of path to view partial.
 */
trait View_Echo_Trait {
	/**
	 * Echo the view safely.
	 *
	 * @since 0.5.1
	 * @return void
	 */
	public function echo_view() {
		$view = $this->view;
		if ( is_string( $view ) ) {
			$view = new View( $view );
		}

		if ( ! $view instanceof View_Interface ) {
			return;
		}

		$view->echo_kses( $this );
	}
}
