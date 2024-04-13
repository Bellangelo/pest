<?php

declare(strict_types=1);

namespace Pest\Support;

use Closure;
use Pest\Expectation;

/**
 * @internal
 */
final class HigherOrderCallables
{
    /**
     * @readonly
     */
    private object $target;
    /**
     * Creates a new Higher Order Callables instances.
     */
    public function __construct(object $target)
    {
        $this->target = $target;
        // ..
    }

    /**
     * @template TValue
     *
     * Create a new expectation. Callable values will be executed prior to returning the new expectation.
     *
     * @param mixed $value
     * @return Expectation<TValue>
     */
    public function expect($value): Expectation
    {
        /** @var TValue $value */
        $value = $value instanceof Closure ? Reflection::bindCallableWithData($value) : $value;

        return new Expectation($value);
    }

    /**
     * @template TValue
     *
     * Create a new expectation. Callable values will be executed prior to returning the new expectation.
     *
     * @param mixed $value
     * @return Expectation<(callable(): mixed)|TValue>
     */
    public function and($value): Expectation
    {
        return $this->expect($value);
    }

    /**
     * Execute the given callable after the test has executed the setup method.
     *
     * @deprecated This method is deprecated. Please use `defer` instead.
     */
    public function tap(callable $callable): object
    {
        return $this->defer($callable);
    }

    /**
     * Execute the given callable after the test has executed the setup method.
     */
    public function defer(callable $callable): object
    {
        Reflection::bindCallableWithData($callable);

        return $this->target;
    }
}
