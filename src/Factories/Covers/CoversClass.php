<?php

declare(strict_types=1);

namespace Pest\Factories\Covers;

/**
 * @internal
 */
final class CoversClass
{
    public string $class;
    public function __construct(string $class)
    {
        $this->class = $class;
    }
}
