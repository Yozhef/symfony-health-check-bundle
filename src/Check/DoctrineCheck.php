<?php

declare(strict_types=1);

namespace SymfonyHealthCheckBundle\Check;

use Doctrine\ORM\EntityManagerInterface;

class DoctrineCheck implements CheckInterface
{
    private const CHECK_RESULT_KEY = 'connection';

    private EntityManagerInterface $entityManager;

    /**
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return bool
     */
    public function isHealthy(): bool
    {
        return $this->entityManager->getConnection()->isConnected();
    }

    /**
     * @return array
     */
    public function check(): array
    {
        return [
            'name' => 'doctrine',
            'connection' => $this->isHealthy()
        ];

    }
}
