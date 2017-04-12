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

use ArrayObject;
use Exception;
use InvalidArgumentException;
use ReflectionFunction;
use ReflectionParameter;
use RuntimeException;

/**
 * Trait FunctionInvokerTrait.
 *
 * Reusable trait that you can pull into any class to have a way of pass an
 * associative array as sorted arguments.
 */
trait FunctionInvokerTrait
{
    /**
     * Check the accepted arguments for a given function and pass associative
     * array values in the right order.
     *
     * @param string      $function Name of the function to invoke.
     * @param ArrayObject $args     Associative array object that contains the arguments.
     *
     * @throws InvalidArgumentException If the function cannot be invoked.
     *
     * @return mixed Return value of the invoked function.
     */
    private function invokeFunction(string $function, ArrayObject $args)
    {
        try {
            $reflection = new ReflectionFunction($function);
            $orderedArguments = $this->parseParameters(
                $reflection->getParameters(),
                $args->getArrayCopy()
            );

            return $reflection->invokeArgs($orderedArguments);
        } catch (Exception $exception) {
            throw new InvalidArgumentException(
                sprintf(
                    'Failed to invoke function "%1$s". Reason: "%2$s"',
                    $function,
                    $exception->getMessage()
                )
            );
        }
    }

    /**
     * Parse the parameters of a function to get the needed order.
     *
     * @param ReflectionParameter[] $params The reflection parameters to parse.
     * @param array                 $args   The arguments to check against.
     *
     * @throws RuntimeException If a $param does not have a name() method.
     *
     * @return array The correctly ordered arguments to pass
     *               to the reflected callable.
     */
    private function parseParameters(array $params, array $args): array
    {
        $orderedArgs = [];
        foreach ($params as $param) {
            if (! $param instanceof ReflectionParameter) {
                throw new RuntimeException(
                    sprintf(
                        'Parameter "%1$s" is not an instance of ReflectionParameter.',
                        $param
                    )
                );
            }
            $orderedArgs[] = array_key_exists($param->name, $args)
                ? $args[ $param->name ]
                : $param->getDefaultValue();
        }

        return $orderedArgs;
    }
}
