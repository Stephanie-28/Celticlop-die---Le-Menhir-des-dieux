<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260823010000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajoute la visibilité publique et le niveau de notoriété des divinités.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE dieu ADD is_visible TINYINT(1) DEFAULT 1 NOT NULL, ADD sacred_level INT DEFAULT 3 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE dieu DROP is_visible, DROP sacred_level');
    }
}
