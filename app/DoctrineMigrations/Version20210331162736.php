<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210331162736 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Final Points';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE final_points (id UUID NOT NULL, competitor_id UUID DEFAULT NULL, competition_id UUID DEFAULT NULL, final_points INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D7B4053E78A5D405 ON final_points (competitor_id)');
        $this->addSql('CREATE INDEX IDX_D7B4053E7B39D312 ON final_points (competition_id)');
        $this->addSql('COMMENT ON COLUMN final_points.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN final_points.competitor_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN final_points.competition_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE final_points ADD CONSTRAINT FK_D7B4053E78A5D405 FOREIGN KEY (competitor_id) REFERENCES competitor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE final_points ADD CONSTRAINT FK_D7B4053E7B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->throwIrreversibleMigrationException();
    }
}
