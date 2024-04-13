<?php

declare(strict_types=1);

namespace Pest\Expectations;

use Pest\Expectation;

use function expect;

/**
 * @internal
 *
 * @template TValue
 *
 * @mixin Expectation<TValue>
 */
final class EachExpectation
{
    private bool $opposite = false;
    /**
     * @var Expectation<TValue>
     * @readonly
     */
    private Expectation $original;

    /**
     * Creates an expectation on each item of the iterable "value".
     *
     * @param  Expectation<TValue>  $original
     */
    public function __construct(Expectation $original)
    {
        $this->original = $original;
    }

    /**
     * Creates a new expectation.
     *
     * @template TAndValue
     *
     * @param mixed $value
     * @return Expectation<TAndValue>
     */
    public function and($value): Expectation
    {
        return $this->original->and($value);
    }

    /**
     * Creates the opposite expectation for the value.
     *
     * @return self<TValue>
     */
    public function not(): self
    {
        $this->opposite = true;

        return $this;
    }

    /**
     * Dynamically calls methods on the class with the given arguments on each item.
     *
     * @param  array<int|string, mixed>  $arguments
     * @return self<TValue>
     */
    public function __call(string $name, array $arguments): self
    {
        foreach ($this->original->value as $item) {
            /* @phpstan-ignore-next-line */
            $this->opposite ? expect($item)->not()->$name(...$arguments) : expect($item)->$name(...$arguments);
        }

        $this->opposite = false;

        return $this;
    }

    /**
     * Dynamically calls methods on the class without any arguments on each item.
     *
     * @return self<TValue>
     */
    public function __get(string $name): self
    {
        /* @phpstan-ignore-next-line */
        return $this->$name();
    }
}
