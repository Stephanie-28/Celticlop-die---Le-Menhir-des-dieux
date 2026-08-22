<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260822031500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Mémorise le titre initiatique choisi manuellement par l’utilisateur.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD selected_initiation_title_level INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP selected_initiation_title_level');
    }
}
