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

use TypistTech\WPBetterSettings\OptionStores\ConstantStrategy;
use TypistTech\WPBetterSettings\OptionStores\DatabaseStrategy;
use TypistTech\WPBetterSettings\OptionStores\FilterStrategy;
use TypistTech\WPBetterSettings\OptionStores\StrategyInterface;

/**
 * Final class OptionStore.
 */
class OptionStore implements OptionStoreInterface
{
    /**
     * Strategies
     *
     * @var StrategyInterface[]
     */
    private $strategies;

    /**
     * OptionStore constructor.
     *
     * @param StrategyInterface[] ...$strategies Strategies to get options.
     */
    public function __construct(StrategyInterface ...$strategies)
    {
        $this->strategies = (count($strategies) > 0) ? $strategies : [
            new ConstantStrategy,
            new DatabaseStrategy,
            new FilterStrategy,
        ];
    }

    /**
     * Get an option value from strategies.
     *
     * @param string $optionName Name of option to retrieve.
     *                           Expected to not be SQL-escaped.
     *
     * @return mixed
     */
    public function get(string $optionName)
    {
        return array_reduce($this->strategies, function ($value, StrategyInterface $strategy) use ($optionName) {
            return $strategy->get($optionName, $value);
        }, null);
    }

    /**
     * Cast option value from strategies into string.
     *
     * @param string $optionName Name of option to retrieve.
     *                           Expected to not be SQL-escaped.
     *
     * @return string
     */
    public function getString(string $optionName): string
    {
        return (string) $this->get($optionName);
    }

    /**
     * Cast option value from strategies into integer.
     *
     * @param string $optionName Name of option to retrieve.
     *                           Expected to not be SQL-escaped.
     *
     * @return int
     */
    public function getInt(string $optionName): int
    {
        return (int) $this->get($optionName);
    }

    /**
     * Cast option value from strategies into boolean.
     *
     * @param string $optionName Name of option to retrieve.
     *                           Expected to not be SQL-escaped.
     *
     * @return bool
     */
    public function getBoolean(string $optionName): bool
    {
        return (bool) $this->get($optionName);
    }
}
