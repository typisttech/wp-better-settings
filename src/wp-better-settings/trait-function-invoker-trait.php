<?php
/**
 * This code is part of the article "Using A Config To Write Reusable Code"
 * as published on https://www.alainschlesser.com/.
 *
 * @see       https://www.alainschlesser.com/config-files-for-reusable-code/
 *
 * @package   WPBS\WP_Better_Settings
 * @author    Alain Schlesser <alain.schlesser@gmail.com>
 * @license   GPL-2.0+
 * @link      https://www.alainschlesser.com/
 * @copyright 2016 Alain Schlesser
 */

namespace WPBS\WP_Better_Settings;

use ArrayObject;
use Exception;
use InvalidArgumentException;
use ReflectionFunction;
use ReflectionParameter;
use RuntimeException;

/**
 * Trait Function_Invoker_Trait.
 *
 * Reusable trait that you can pull into any class to have a way of pass an
 * associative array as sorted arguments.
 *
 * @since 0.1.0
 */
trait Function_Invoker_Trait {
	/**
	 * Check the accepted arguments for a given function and pass associative
	 * array values in the right order.
	 *
	 * @since 0.1.0
	 *
	 * @param string      $function Name of the function to invoke.
	 * @param ArrayObject $args     Associative array object that contains the arguments.
	 *
	 * @return mixed                Return value of the invoked function.
	 * @throws InvalidArgumentException If the function cannot be invoked.
	 */
	public function invoke_function( string $function, ArrayObject $args ) {
		try {
			$reflection        = new ReflectionFunction( $function );
			$ordered_arguments = $this->parse_parameters(
				$reflection->getParameters(),
				$args->getArrayCopy()
			);

			return $reflection->invokeArgs( $ordered_arguments );
		} catch ( Exception $exception ) {
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
	 * @since 0.1.0
	 *
	 * @param ReflectionParameter[] $params The reflection parameters to parse.
	 * @param array                 $args   The arguments to check against.
	 *
	 * @return array                        The correctly ordered arguments to pass
	 *                                      to the reflected callable.
	 * @throws RuntimeException                If a $param does not have a name() method.
	 */
	private function parse_parameters( array $params, array $args ) : array {
		$ordered_args = [];
		foreach ( $params as $param ) {
			if ( ! $param instanceof ReflectionParameter ) {
				throw new RuntimeException(
					sprintf(
						'Parameter "%1$s" is not an instance of ReflectionParameter.',
						$param
					)
				);
			}
			$ordered_args[] = array_key_exists( $param->name, $args )
				? $args[ $param->name ]
				: $param->getDefaultValue();
		}

		return $ordered_args;
	}
}
