<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210313131457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change Credentials';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE host DROP credentials_username');
        $this->addSql('ALTER TABLE host DROP credentials_password');
        $this->addSql('ALTER TABLE host ALTER credentials_auth_token SET NOT NULL');
        $this->addSql('ALTER TABLE host ADD email_address VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->throwIrreversibleMigrationException(l);
    }
}
