<?php

declare(strict_types=1);

namespace Pest;

use NunoMaduro\Collision\Writer;
use Pest\Support\Container;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;
use Whoops\Exception\Inspector;

final class Panic
{
    /**
     * @readonly
     */
    private Throwable $throwable;
    /**
     * Creates a new Panic instance.
     */
    private function __construct(
        Throwable $throwable
    ) {
        $this->throwable = $throwable;
        // ...
    }

    /**
     * Creates a new Panic instance, and exits the application.
     * @return never
     */
    public static function with(Throwable $throwable)
    {
        $panic = new self($throwable);

        $panic->handle();

        exit(1);
    }

    /**
     * Handles the panic.
     */
    private function handle(): void
    {
        try {
            $output = Container::getInstance()->get(OutputInterface::class);
        } catch (Throwable $exception) { // @phpstan-ignore-line
            $output = new ConsoleOutput();
        }

        assert($output instanceof OutputInterface);

        if ($this->throwable instanceof Contracts\Panicable) {
            $this->throwable->render($output);

            exit($this->throwable->exitCode());
        }

        $writer = new Writer(null, $output);

        $inspector = new Inspector($this->throwable);

        $writer->write($inspector);
        $output->writeln('');

        exit(1);
    }
}
