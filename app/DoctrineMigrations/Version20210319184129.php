<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210319184129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Description to Competitions';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE competition ADD description TEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->throwIrreversibleMigrationException();
    }
}
