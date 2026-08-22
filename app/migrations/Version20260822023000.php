<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260822023000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Mémorise le dernier niveau initiatique présenté à l’utilisateur.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD last_presented_initiation_level INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP last_presented_initiation_level');
    }
}
