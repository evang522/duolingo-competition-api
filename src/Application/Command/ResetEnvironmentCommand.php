<?php

declare(strict_types=1);

namespace App\Application\Command;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ResetEnvironmentCommand extends Command
{
    private string $environment;

    public function __construct(
        string $environment
    ) {
        $this->environment = $environment;
        parent::__construct();
    }

    public function configure(): void
    {
        parent::configure();

        $this
            ->setName('duo:env:reset')
            ->setDescription('Drops all database tables and schemas, and creates new fixtures for development.');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if ($this->environment === 'prod') {
            $io->error('Cannot reset production environment.');

            return 0;
        }

        $this->runCommand('doctrine:query:sql', ['sql' => 'DROP TABLE IF EXISTS migration_versions']);

        $io->text('Dropping schema.');
        $this->runCommand('doctrine:schema:drop', ['--force' => true]);

        $io->text('Running migrations.');
        $this->runCommand('doctrine:migrations:migrate');

//        $io->text('Loading Fixtures');
//        $this->runCommand('doctrine:fixtures:load', ['--append' => '']);


        $io->success('Successfully Reset DB');

        return 0;
    }

    /**
     * Run another command.
     *
     * @param string  $name    The name of the command.
     * @param mixed[] $options The options.
     *
     * @throws Exception
     */
    private function runCommand(string $name, array $options = []): bool
    {
        $command = $this->getApplication()->get($name);
        $command->mergeApplicationDefinition();
        $command = clone $command;

        $parameters = \array_merge($options, ['command' => $name, '--env' => $this->environment]);
        $input      = new ArrayInput($parameters);
        $input->setInteractive(false);

        $returnCode = $command->run($input, new NullOutput());

        return $returnCode === 0;
    }
}
