<?php

declare(strict_types=1);

namespace Pest\PendingCalls;

use Closure;
use Pest\Support\Backtrace;
use Pest\TestSuite;

/**
 * @internal
 */
final class DescribeCall
{
    /**
     * The current describe call.
     */
    private static ?string $describing = null;
    /**
     * @readonly
     */
    public TestSuite $testSuite;
    /**
     * @readonly
     */
    public string $filename;
    /**
     * @readonly
     */
    public string $description;
    /**
     * @readonly
     */
    public Closure $tests;

    /**
     * Creates a new Pending Call.
     */
    public function __construct(
        TestSuite $testSuite,
        string $filename,
        string $description,
        Closure $tests
    ) {
        $this->testSuite = $testSuite;
        $this->filename = $filename;
        $this->description = $description;
        $this->tests = $tests;
        //
    }

    /**
     * What is the current describing.
     */
    public static function describing(): ?string
    {
        return self::$describing;
    }

    /**
     * Creates the Call.
     */
    public function __destruct()
    {
        self::$describing = $this->description;

        try {
            ($this->tests)();
        } finally {
            self::$describing = null;
        }
    }

    /**
     * Dynamically calls methods on each test call.
     *
     * @param  array<int, mixed>  $arguments
     */
    public function __call(string $name, array $arguments): BeforeEachCall
    {
        $filename = Backtrace::file();

        $beforeEachCall = new BeforeEachCall(TestSuite::getInstance(), $filename);

        $beforeEachCall->describing = $this->description;

        return $beforeEachCall->{$name}(...$arguments); // @phpstan-ignore-line
    }
}
