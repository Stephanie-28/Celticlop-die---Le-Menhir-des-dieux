<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260803143530 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dieu_symbole (dieu_id INT NOT NULL, symbole_id INT NOT NULL, INDEX IDX_CCDFB6CB595D5DAB (dieu_id), INDEX IDX_CCDFB6CBC5ABF715 (symbole_id), PRIMARY KEY (dieu_id, symbole_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE dieu_symbole ADD CONSTRAINT FK_CCDFB6CB595D5DAB FOREIGN KEY (dieu_id) REFERENCES dieu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dieu_symbole ADD CONSTRAINT FK_CCDFB6CBC5ABF715 FOREIGN KEY (symbole_id) REFERENCES symbole (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dieu_symbole DROP FOREIGN KEY FK_CCDFB6CB595D5DAB');
        $this->addSql('ALTER TABLE dieu_symbole DROP FOREIGN KEY FK_CCDFB6CBC5ABF715');
        $this->addSql('DROP TABLE dieu_symbole');
    }
}
