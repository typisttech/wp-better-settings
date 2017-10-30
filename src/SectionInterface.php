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

use Closure;

interface SectionInterface
{
    /**
     * String for use in the 'id' attribute of tags.
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Title of the section.
     *
     * @return string
     */
    public function getTitle(): string;

    /**
     * Closure that fills the section with the desired content. The closure should echo its output.
     *
     * @return Closure
     */
    public function getRenderClosure(): Closure;

    /**
     * Add fields into this section.
     *
     * @param FieldInterface[] ...$fields Fields to be registered in this section.
     */
    public function add(FieldInterface ...$fields);

    /**
     * Fields getter.
     *
     * @return FieldInterface[]
     */
    public function getFields(): array;
}
