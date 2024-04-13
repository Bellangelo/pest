<?php

declare(strict_types=1);

namespace Pest\Logging\TeamCity\Subscriber;

use Pest\Logging\TeamCity\TeamCityLogger;

/**
 * @internal
 */
abstract class Subscriber
{
    /**
     * @readonly
     */
    private TeamCityLogger $logger;
    /**
     * Creates a new Subscriber instance.
     */
    public function __construct(TeamCityLogger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Creates a new TeamCityLogger instance.
     */
    final protected function logger(): TeamCityLogger
    {
        return $this->logger;
    }
}
