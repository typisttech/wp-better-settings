<?php
/**
 * WP Better Settings
 *
 * A simplified OOP implementation of the WP Settings API.
 *
 * @package   TypistTech\WPBetterSettings
 *
 * @author    Typist Tech <wp-better-settings@typist.tech>
 * @copyright 2017 Typist Tech
 * @license   GPL-2.0+
 *
 * @see       https://www.typist.tech/projects/wp-better-settings
 * @see       https://github.com/TypistTech/wp-better-settings
 */

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

/**
 * Trait ViewEchoTrait.
 *
 * Reusable trait that you can use in any ArrayObject
 * which has a ViewInterface or String as view property.
 */
trait ViewEchoTrait
{
    /**
     * Echo the view safely.
     *
     * @return void
     */
    public function echoView()
    {
        $view = $this->view;
        if (is_string($view)) {
            $view = new View($view);
        }

        if (! $view instanceof ViewInterface) {
            return;
        }

        $view->echoKses($this);
    }

    /**
     * Returns the function to be called to output the content for this page.
     *
     * @todo Move to ViewEchoTrait.
     *
     * @return callable
     */
    public function getCallbackFunction(): callable
    {
        return [ $this, 'echoView' ];
    }
}
