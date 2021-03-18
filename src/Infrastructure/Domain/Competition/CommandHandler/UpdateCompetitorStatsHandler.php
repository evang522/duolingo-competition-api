<?php

declare(strict_types=1);

namespace App\Infrastructure\Domain\Competition\CommandHandler;

use App\Domain\Competition\Command\UpdateCompetitorStats;
use App\Domain\Competition\Entity\Competitor;
use App\Domain\Competition\Entity\Host;
use App\Infrastructure\Domain\Competition\Repository\CompetitorRepository;
use App\Infrastructure\Domain\Competition\Repository\HostRepository;
use App\Infrastructure\Duolingo\Service\Client;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UpdateCompetitorStatsHandler implements MessageHandlerInterface
{
    private Client $duolingoClient;
    private HostRepository $hostRepository;
    private CompetitorRepository $competitorRepository;

    public function __construct(
        Client $duolingoClient,
        HostRepository $hostRepository,
        CompetitorRepository $competitorRepository
    ) {
        $this->duolingoClient       = $duolingoClient;
        $this->hostRepository       = $hostRepository;
        $this->competitorRepository = $competitorRepository;
    }

    public function __invoke(UpdateCompetitorStats $command): void
    {
        $host = $this->hostRepository->find($command->hostId());
        \assert($host instanceof Host);

        $competitor = $this->competitorRepository->find($command->competitorId());
        \assert($competitor instanceof Competitor);

        $information = $this->duolingoClient->getCompetitorInformation($competitor, $host);

        $competitor->setCurrentLanguage($information->currentLanguage());
        $competitor->setProfilePhotoUrl($information->profilePhotoUrl());
        $competitor->setTotalPoints($information->totalPoints());
        $competitor->setUsername($information->duoUsername());
        $competitor->setStreak($information->streak());
    }
}
