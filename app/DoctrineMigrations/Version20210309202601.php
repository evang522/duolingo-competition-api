<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210309202601 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

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
        $this->addSql('CREATE TABLE competitor (id UUID NOT NULL, finished_at INT NOT NULL, current_language VARCHAR(255) NOT NULL, duolingo_id VARCHAR(255) NOT NULL, duolingo_username VARCHAR(255) NOT NULL, profile_photo_url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN competitor.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE competitor_competition (competitor_id UUID NOT NULL, competition_id UUID NOT NULL, PRIMARY KEY(competitor_id, competition_id))');
        $this->addSql('CREATE INDEX IDX_F133CB8878A5D405 ON competitor_competition (competitor_id)');
        $this->addSql('CREATE INDEX IDX_F133CB887B39D312 ON competitor_competition (competition_id)');
        $this->addSql('COMMENT ON COLUMN competitor_competition.competitor_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN competitor_competition.competition_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE host (id UUID NOT NULL, credentials_username VARCHAR(255) NOT NULL, credentials_password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN host.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE host_auth (id UUID NOT NULL, host_id UUID DEFAULT NULL, auth_token VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2693373B1FB8D185 ON host_auth (host_id)');
        $this->addSql('COMMENT ON COLUMN host_auth.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN host_auth.host_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE base_points ADD CONSTRAINT FK_4FDA164078A5D405 FOREIGN KEY (competitor_id) REFERENCES competitor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE base_points ADD CONSTRAINT FK_4FDA16407B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB1CF2713FD FOREIGN KEY (host) REFERENCES host (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE competitor_competition ADD CONSTRAINT FK_F133CB8878A5D405 FOREIGN KEY (competitor_id) REFERENCES competitor (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE competitor_competition ADD CONSTRAINT FK_F133CB887B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE host_auth ADD CONSTRAINT FK_2693373B1FB8D185 FOREIGN KEY (host_id) REFERENCES host (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE base_points DROP CONSTRAINT FK_4FDA16407B39D312');
        $this->addSql('ALTER TABLE competitor_competition DROP CONSTRAINT FK_F133CB887B39D312');
        $this->addSql('ALTER TABLE base_points DROP CONSTRAINT FK_4FDA164078A5D405');
        $this->addSql('ALTER TABLE competitor_competition DROP CONSTRAINT FK_F133CB8878A5D405');
        $this->addSql('ALTER TABLE competition DROP CONSTRAINT FK_B50A2CB1CF2713FD');
        $this->addSql('ALTER TABLE host_auth DROP CONSTRAINT FK_2693373B1FB8D185');
        $this->addSql('DROP TABLE base_points');
        $this->addSql('DROP TABLE competition');
        $this->addSql('DROP TABLE competitor');
        $this->addSql('DROP TABLE competitor_competition');
        $this->addSql('DROP TABLE host');
        $this->addSql('DROP TABLE host_auth');
    }
}
