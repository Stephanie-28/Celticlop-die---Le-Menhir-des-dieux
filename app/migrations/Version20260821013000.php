<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260821013000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajoute le prénom, le nom et la devise au profil de l’Initié.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD first_name VARCHAR(100) DEFAULT NULL, ADD last_name VARCHAR(100) DEFAULT NULL, ADD motto VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP first_name, DROP last_name, DROP motto');
    }
}
