<?php

declare(strict_types=1);

namespace Pest\Bootstrappers;

use Pest\Contracts\Bootstrapper;
use Pest\KernelDump;
use Pest\Support\Container;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @internal
 */
final class BootKernelDump implements Bootstrapper
{
    /**
     * @readonly
     */
    private OutputInterface $output;
    /**
     * Creates a new Boot Kernel Dump instance.
     */
    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
        // ...
    }
    /**
     * Boots the kernel dump.
     */
    public function boot(): void
    {
        Container::getInstance()->add(KernelDump::class, $kernelDump = new KernelDump(
            $this->output,
        ));

        $kernelDump->enable();
    }
}
