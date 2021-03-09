<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210309174532 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE host_auth (id UUID NOT NULL, host_id UUID DEFAULT NULL, auth_token VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2693373B1FB8D185 ON host_auth (host_id)');
        $this->addSql('COMMENT ON COLUMN host_auth.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN host_auth.host_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE host_auth ADD CONSTRAINT FK_2693373B1FB8D185 FOREIGN KEY (host_id) REFERENCES host (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE host_auth');
    }
}
