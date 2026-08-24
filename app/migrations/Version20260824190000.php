<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260824190000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajoute le résumé et le type éditorial des Savoirs préservés.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE savoir ADD summary LONGTEXT DEFAULT NULL, ADD editorial_type VARCHAR(20) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE savoir DROP summary, DROP editorial_type');
    }
}
