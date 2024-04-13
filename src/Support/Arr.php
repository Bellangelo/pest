<?php

declare(strict_types=1);

namespace Pest\Support;

/**
 * @internal
 */
final class Arr
{
    /**
     * Checks if the given array has the given key.
     *
     * @param  array<array-key, mixed>  $array
     * @param string|int $key
     */
    public static function has(array $array, $key): bool
    {
        $key = (string) $key;

        if (array_key_exists($key, $array)) {
            return true;
        }

        foreach (explode('.', $key) as $segment) {
            if (is_array($array) && array_key_exists($segment, $array)) {
                $array = $array[$segment];
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * Gets the given key value.
     *
     * @param  array<array-key, mixed>  $array
     * @param string|int $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(array $array, $key, $default = null)
    {
        $key = (string) $key;

        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        if (strpos($key, '.') === false) {
            return $array[$key] ?? $default;
        }

        foreach (explode('.', $key) as $segment) {
            if (is_array($array) && array_key_exists($segment, $array)) {
                $array = $array[$segment];
            } else {
                return $default;
            }
        }

        return $array;
    }

    /**
     * Flatten a multi-dimensional associative array with dots.
     *
     * @param  array<array-key, mixed>  $array
     * @return array<int|string, mixed>
     */
    public static function dot(array $array, string $prepend = ''): array
    {
        $results = [];

        foreach ($array as $key => $value) {
            if (is_array($value) && $value !== []) {
                $results = array_merge($results, self::dot($value, $prepend.$key.'.'));
            } else {
                $results[$prepend.$value] = $value;
            }
        }

        return $results;
    }
}
