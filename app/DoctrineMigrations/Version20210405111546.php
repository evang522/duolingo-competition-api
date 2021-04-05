<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210405111546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Fix relationships between base_points and final_points';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('DROP INDEX uniq_4fda164078a5d405');
        $this->addSql('CREATE INDEX IDX_4FDA164078A5D405 ON base_points (competitor_id)');
        $this->addSql('DROP INDEX uniq_d7b4053e78a5d405');
        $this->addSql('CREATE INDEX IDX_D7B4053E78A5D405 ON final_points (competitor_id)');
    }

    public function down(Schema $schema): void
    {
        $this->throwIrreversibleMigrationException();
    }
}
