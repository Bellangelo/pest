<?php

declare(strict_types=1);

namespace Pest\Factories\Covers;

/**
 * @internal
 */
final class CoversFunction
{
    public string $function;
    public function __construct(string $function)
    {
        $this->function = $function;
    }
}
