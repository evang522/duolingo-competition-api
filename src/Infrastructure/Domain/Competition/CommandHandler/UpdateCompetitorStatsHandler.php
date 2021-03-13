<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Competition\CommandHandler;

use App\Domain\Competition\Command\UpdateCompetitorStats;
use App\Domain\Competition\Entity\Competitor;
use App\Domain\Competition\Entity\Host;
use App\Infrastructure\Domain\Competition\HostAuthSync;
use App\Infrastructure\Domain\Competition\Repository\CompetitorRepository;
use App\Infrastructure\Domain\Competition\Repository\HostRepository;
use App\Infrastructure\Duolingo\Service\Client;
use Http\Client\HttpClient;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UpdateCompetitorStatsHandler implements MessageHandlerInterface
{
    private HttpClient $httpClient;
    private Client $duolingoClient;
    private HostRepository $hostRepository;
    private HostAuthSync $hostAuthSync;
    private CompetitorRepository $competitorRepository;

    public function __construct(
        HttpClient $httpClient,
        Client $duolingoClient,
        HostRepository $hostRepository,
        HostAuthSync $hostAuthSync,
        CompetitorRepository $competitorRepository
    ) {
        $this->httpClient           = $httpClient;
        $this->duolingoClient       = $duolingoClient;
        $this->hostRepository       = $hostRepository;
        $this->hostAuthSync         = $hostAuthSync;
        $this->competitorRepository = $competitorRepository;
    }

    public function __invoke(UpdateCompetitorStats $command): void
    {
        $host = $this->hostRepository->find($command->hostId());
        \assert($host instanceof Host);

        $competitor = $this->competitorRepository->find($command->competitorId());
        \assert($competitor instanceof Competitor);

        $this->hostAuthSync->syncHostAuth($host);

        $information = $this->duolingoClient->getCompetitorInformation($competitor, $host);

        $competitor->setCurrentLanguage($information->currentLanguage());
        $competitor->setProfilePhotoUrl($information->profilePhotoUrl());
        $competitor->setTotalPoints($information->totalPoints());
    }
}
