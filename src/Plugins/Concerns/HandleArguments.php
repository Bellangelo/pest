<?php

declare(strict_types=1);

namespace Pest\Plugins\Concerns;

/**
 * @internal
 */
trait HandleArguments
{
    /**
     * Checks if the given argument exists on the arguments.
     *
     * @param  array<int, string>  $arguments
     */
    public function hasArgument(string $argument, array $arguments): bool
    {
        foreach ($arguments as $arg) {
            if ($arg === $argument) {
                return true;
            }

            if (strncmp($arg, "$argument=", strlen("$argument=")) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Adds the given argument and value to the list of arguments.
     *
     * @param  array<int, string>  $arguments
     * @return array<int, string>
     */
    public function pushArgument(string $argument, array $arguments): array
    {
        $arguments[] = $argument;

        return $arguments;
    }

    /**
     * Pops the given argument from the arguments.
     *
     * @param  array<int, string>  $arguments
     * @return array<int, string>
     */
    public function popArgument(string $argument, array $arguments): array
    {
        $arguments = array_flip($arguments);

        unset($arguments[$argument]);

        return array_values(array_flip($arguments));
    }
}
