<?php

declare(strict_types=1);

namespace Pest\Concerns;

/**
 * @internal
 */
trait Retrievable
{
    /**
     * @template TRetrievableValue
     *
     * Safely retrieve the value at the given key from an object or array.
     * @template TRetrievableValue
     *
     * @param mixed $value
     * @param mixed $default
     * @return TRetrievableValue|null
     */
    private function retrieve(string $key, $value, $default = null)
    {
        if (is_array($value)) {
            return $value[$key] ?? $default;
        }

        // @phpstan-ignore-next-line
        return $value->$key ?? $default;
    }
}
