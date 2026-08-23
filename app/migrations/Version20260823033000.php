<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260823033000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Aligne la catégorie obligatoire des mythes sur son mapping Doctrine.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE mythe MODIFY category VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE mythe MODIFY category VARCHAR(255) DEFAULT NULL');
    }
}
