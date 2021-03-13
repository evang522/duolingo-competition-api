<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210312173911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE base_points (id UUID NOT NULL, competitor_id UUID DEFAULT NULL, competition_id UUID DEFAULT NULL, base_points INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FDA164078A5D405 ON base_points (competitor_id)');
        $this->addSql('CREATE INDEX IDX_4FDA16407B39D312 ON base_points (competition_id)');
        $this->addSql('COMMENT ON COLUMN base_points.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN base_points.competitor_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN base_points.competition_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE competition (id UUID NOT NULL, host UUID DEFAULT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B50A2CB1CF2713FD ON competition (host)');
        $this->addSql('COMMENT ON COLUMN competition.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN competition.host IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN competition.start_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN competition.end_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE competition_competitor (competition_id UUID NOT NULL, competitor_id UUID NOT NULL, PRIMARY KEY(competition_id, competitor_id))');
        $this->addSql('CREATE INDEX IDX_43C2DB927B39D312 ON competition_competitor (competition_id)');
        $this->addSql('CREATE INDEX IDX_43C2DB9278A5D405 ON competition_competitor (competitor_id)');
        $this->addSql('COMMENT ON COLUMN competition_competitor.competition_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN competition_competitor.competitor_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE competitor (id UUID NOT NULL, total_points INT NOT NULL, current_language VARCHAR(255) NOT NULL, duolingo_id VARCHAR(255) NOT NULL, duolingo_username VARCHAR(255) NOT NULL, profile_photo_url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN competitor.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE host (id UUID NOT NULL, credentials_username VARCHAR(255) NOT NULL, credentials_password VARCHAR(255) NOT NULL, credentials_auth_token VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN host.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE base_points ADD CONSTRAINT FK_4FDA164078A5D405 FOREIGN KEY (competitor_id) REFERENCES competitor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE base_points ADD CONSTRAINT FK_4FDA16407B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB1CF2713FD FOREIGN KEY (host) REFERENCES host (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE competition_competitor ADD CONSTRAINT FK_43C2DB927B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE competition_competitor ADD CONSTRAINT FK_43C2DB9278A5D405 FOREIGN KEY (competitor_id) REFERENCES competitor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->throwIrreversibleMigrationException();
    }
}
