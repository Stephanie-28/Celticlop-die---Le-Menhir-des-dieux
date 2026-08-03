<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260803143937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dieu_animal (dieu_id INT NOT NULL, animal_id INT NOT NULL, INDEX IDX_5AC83B11595D5DAB (dieu_id), INDEX IDX_5AC83B118E962C16 (animal_id), PRIMARY KEY (dieu_id, animal_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE dieu_animal ADD CONSTRAINT FK_5AC83B11595D5DAB FOREIGN KEY (dieu_id) REFERENCES dieu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dieu_animal ADD CONSTRAINT FK_5AC83B118E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dieu_animal DROP FOREIGN KEY FK_5AC83B11595D5DAB');
        $this->addSql('ALTER TABLE dieu_animal DROP FOREIGN KEY FK_5AC83B118E962C16');
        $this->addSql('DROP TABLE dieu_animal');
    }
}
