<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210811184212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Public Property to Competitions';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE competition ADD public BOOLEAN NOT NULL DEFAULT true');
    }

    public function down(Schema $schema): void
    {
        $this->throwIrreversibleMigrationException();
    }
}
