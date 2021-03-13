<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210313163041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Winner to Competition';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE competition ADD winner_id UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN competition.winner_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB15DFCD4B8 FOREIGN KEY (winner_id) REFERENCES competitor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B50A2CB15DFCD4B8 ON competition (winner_id)');
    }

    public function down(Schema $schema): void
    {
        $this->throwIrreversibleMigrationException();
    }
}
