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
 * Trait ViewAwareTrait.
 */
trait ViewAwareTrait
{
    /**
     * ViewInterface object to render.
     *
     * @var ViewInterface
     */
    protected $view;

    /**
     * Echo the view safely.
     *
     * @return void
     */
    public function echoView()
    {
        $this->view->echoKses($this);
    }

    /**
     * Returns the function to be called to output the content for this page.
     *
     * @return callable
     */
    public function getCallbackFunction(): callable
    {
        return [ $this, 'echoView' ];
    }

    /**
     * View setter.
     *
     * @param ViewInterface $view The view object.
     *
     * @return void
     */
    public function setView(ViewInterface $view)
    {
        $this->view = $view;
    }
}
