<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Competition;

use App\Domain\Competition\Entity\Host;
use App\Infrastructure\Domain\Competition\Repository\HostRepository;
use App\Infrastructure\Duolingo\Service\Client;

class HostAuthSync
{
    private Client $duolingoClient;
    private HostRepository $hostRepository;

    public function __construct(
        Client $duolingoClient,
        HostRepository $hostRepository
    ) {
        $this->duolingoClient = $duolingoClient;
        $this->hostRepository = $hostRepository;
    }

    public function syncHostAuth(Host $host): void
    {
        $token = $this->duolingoClient->getTokenForHost($host);
        $host->credentials()->setAuthToken($token);
        $this->hostRepository->store($host);
    }
}
