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

namespace TypistTech\WPBetterSettings\Fields;

use TypistTech\WPBetterSettings\ExtraAwareTrait;
use TypistTech\WPBetterSettings\View;
use TypistTech\WPBetterSettings\ViewAwareTrait;
use TypistTech\WPBetterSettings\ViewFactory;
use TypistTech\WPBetterSettings\ViewInterface;

/**
 * Abstract class AbstractField
 */
abstract class AbstractField implements FieldInterface
{
    use ExtraAwareTrait;
    use ViewAwareTrait;

    const DEFAULT_VIEW_PARTIAL = self::DEFAULT_VIEW_PARTIAL;

    /**
     * ID of this field. Should be unique for each section/page.
     *
     * @var string
     */
    protected $id;

    /**
     * Function that sanitize this field.
     *
     * @var callable|null
     */
    protected $sanitizeCallback;

    /**
     * Title of the field.
     *
     * @var string
     */
    protected $title;

    /**
     * Option value.
     *
     * @var mixed
     */
    protected $value;

    /**
     * AbstractField constructor.
     *
     * @param string             $id               ID of this field. Should be unique for each section/page.
     * @param string             $title            Title of the field.
     * @param array|null         $extra            Optional. Additional information that is passed to the template
     *                                             partial through view object.
     * @param mixed|null         $sanitizeCallback Optional. Function that sanitize this field.
     * @param ViewInterface|null $view             Optional. ViewInterface object to render.
     */
    public function __construct(
        string $id,
        string $title,
        array $extra = null,
        $sanitizeCallback = null,
        ViewInterface $view = null
    ) {
        $this->id = $id;
        $this->title = $title;

        $this->sanitizeCallback = $sanitizeCallback;
        $this->view = $view ?? $this->getDefaultView();
        $this->extra = $extra ?? [];
    }

    /**
     * Default view getter.
     *
     * @return View
     */
    protected function getDefaultView(): View
    {
        return ViewFactory::build(static::DEFAULT_VIEW_PARTIAL);
    }

    /**
     * Get description from extra.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->extra['desc'] ?? '';
    }

    /**
     * Get htmlClass from extra.
     *
     * @return string
     */
    public function getHtmlClass(): string
    {
        return $this->extra['htmlClass'] ?? 'regular-text';
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getSanitizeCallback(): callable
    {
        return $this->sanitizeCallback ?? 'sanitize_text_field';
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Value getter.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Value setter.
     *
     * @param mixed $value Field value.
     *
     * @return void
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get disabled from extra.
     *
     * @return bool
     */
    public function isDisabled(): bool
    {
        return $this->extra['disabled'] ?? false;
    }
}
