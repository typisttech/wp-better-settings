<?php
/**
 * A simplified OOP implementation of the WP Settings API
 *
 * @package   WPBS\WP_Better_Settings
 * @author    Tang Rufus <rufus@typist.tech>
 * @license   GPL-2.0+
 * @link      https://www.typist.tech/
 * @copyright 2017 Tang Rufus
 */

namespace WPBS\WP_Better_Settings;

/**
 * Class View
 *
 * Accepts a filename of a PHP file and renders its content on request.
 */
class View {

	/**
	 * Filename of the PHP view to render.
	 *
	 * @since 0.1.0
	 *
	 * @var string
	 */
	protected $filename;
	/**
	 * Array of allowed tags to let through escaping.
	 *
	 * @since 0.1.0
	 *
	 * @var array
	 */
	protected $allowed_tags = [];

	/**
	 * View constructor.
	 *
	 * @since 0.1.0
	 *
	 * @param string $filename      Filename of the PHP view to render.
	 * @param array  $allowed_tags  [Optional] Array of allowed tags to
	 *                              let through escaping functions. Set
	 *                              to sane defaults if none provided.
	 */
	public function __construct( string $filename, array $allowed_tags = null ) {
		$this->filename     = $filename;
		$this->allowed_tags = null === $allowed_tags
			? $this->default_allowed_tags()
			: $allowed_tags;
	}

	/**
	 * Prepare an array of allowed tags by adding form elements to the existing
	 * array.
	 *
	 * This makes sure that the basic form elements always pass through the
	 * escaping functions.
	 *
	 * @since 0.1.0
	 *
	 * @return array Modified tags array.
	 */
	protected function default_allowed_tags() : array {
		$form_tags = [
			'form'  => [
				'id'     => true,
				'class'  => true,
				'action' => true,
				'method' => true,
			],
			'input' => [
				'id'    => true,
				'class' => true,
				'type'  => true,
				'name'  => true,
				'value' => true,
			],
		];

		return array_replace_recursive( wp_kses_allowed_html( 'post' ), $form_tags );
	}

	/**
	 * Render a given view.
	 *
	 * @since 0.1.0
	 *
	 * @param string|View $view       View to render. Can be a path to a view file
	 *                                or an instance of a View object.
	 * @param mixed       $context    Context ArrayObject for which to render
	 *                                the view.
	 */
	static public function kses_render( $view, $context ) {
		$view_object = is_string( $view ) ? new View( $view ) : $view;

		echo wp_kses(
			$view_object->render( $context ),
			$view_object->allowed_tags
		);
	}

	/**
	 * Render the associated view.
	 *
	 * @since 0.1.0
	 *
	 * @see   https://github.com/Medium/medium-wordpress-plugin/blob/c31713968990bab5d83db68cf486953ea161a009/lib/medium-view.php
	 *
	 * @param mixed $context Context variables.
	 * @param bool  $return  [Optional] To return or to echo.
	 *
	 * @return string           Void if $return = true, or file is not readable.
	 *                          Otherwise, returns HTML string.
	 */
	public function render( $context, bool $return = true ) {
		if ( ! is_readable( $this->filename ) ) {
			return '';
		}

		ob_start();
		include $this->filename;
		if ( $return ) {
			return ob_get_clean();
		} else {
			return ob_end_flush();
		}
	}

	/**
	 * Filename getter
	 *
	 * @since 0.1.0
	 *
	 * @return string
	 */
	public function get_filename() : string {
		return $this->filename;
	}
}
