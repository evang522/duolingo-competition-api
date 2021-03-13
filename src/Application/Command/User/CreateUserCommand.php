<?php

declare(strict_types=1);

namespace App\Application\Command\User;

use App\Domain\User\Entity\AdminUser;
use App\Infrastructure\Domain\User\Service\UserPasswordUpdater;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateUserCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private UserPasswordUpdater $passwordUpdater;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordUpdater $passwordUpdater
    )
    {
        $this->entityManager = $entityManager;
        $this->passwordUpdater = $passwordUpdater;
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = $io->askQuestion(new Question('What Email Address?'));
        $plainPassword = $io->askQuestion(new Question('Plain Password'));

        try {
            $user = new AdminUser();
            $user->setEmail($email);
            $user->setPlainTextPassword($plainPassword);

            $this->passwordUpdater->updatePassword($user);

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (\RuntimeException $exception) {
            $io->error('User Creation Failed: ' . $exception->getMessage());
        }


        return 0;
    }

    protected function configure(): void
    {
        $this->setName('duo:user:create');
    }
}
