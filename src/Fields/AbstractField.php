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

use TypistTech\WPBetterSettings\View;
use TypistTech\WPBetterSettings\ViewEchoTrait;
use TypistTech\WPBetterSettings\ViewInterface;

/**
 * Abstract class Input
 */
abstract class AbstractField
{
    // TODO: Test ViewEchoTrait.
    use ViewEchoTrait;

    /**
     * ViewInterface object to render.
     *
     * @todo Move to ViewEchoTrait.
     *
     * @var ViewInterface
     */
    protected $view;

    /**
     * Additional information that is passed to the template partial through view object.
     *
     * @var array
     */
    protected $extra;

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
     * Input constructor.
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
    abstract protected function getDefaultView(): View;

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
     * Extra getter.
     *
     * @return array
     */
    public function getExtra(): array
    {
        return $this->extra;
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
     * Id getter.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get name from extra.
     *
     * @return string
     */
    public function getName(): string
    {
        return sprintf(
            '%s[%s]',
            esc_html($this->extra['optionName']),
            esc_html($this->id)
        );
    }

    /**
     * SanitizeCallback getter.
     *
     * @return callable
     */
    public function getSanitizeCallback(): callable
    {
        return $this->sanitizeCallback ?? 'sanitize_text_field';
    }

    /**
     * Title getter.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Get value from extra.
     *
     * @return mixed|null
     */
    public function getValue()
    {
        return $this->extra['value'] ?? null;
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

    /**
     * Extra element setter.
     *
     * @param string $key   Key of the extra array.
     * @param mixed  $value Value of $extra[$key].
     *
     * @return void
     */
    public function setExtraElement(string $key, $value)
    {
        $this->extra[ $key ] = $value;
    }
}
