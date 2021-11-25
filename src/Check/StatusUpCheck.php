<?php

declare(strict_types=1);

namespace SymfonyHealthCheckBundle\Check;

class StatusUpCheck implements CheckInterface
{

    public function isHealthy(): bool
    {
        return true;
    }

    public function check(): array
    {
        return [
            'name' => 'symfony',
            'status' => true,
        ];
    }
}
