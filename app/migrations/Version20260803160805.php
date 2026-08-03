<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260803160805 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dieu_mythe (dieu_id INT NOT NULL, mythe_id INT NOT NULL, INDEX IDX_A454F8EC595D5DAB (dieu_id), INDEX IDX_A454F8ECFB3597B3 (mythe_id), PRIMARY KEY (dieu_id, mythe_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE dieu_mythe ADD CONSTRAINT FK_A454F8EC595D5DAB FOREIGN KEY (dieu_id) REFERENCES dieu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dieu_mythe ADD CONSTRAINT FK_A454F8ECFB3597B3 FOREIGN KEY (mythe_id) REFERENCES mythe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dieu ADD music_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dieu ADD CONSTRAINT FK_EAE355B6399BBB13 FOREIGN KEY (music_id) REFERENCES music (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EAE355B6399BBB13 ON dieu (music_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dieu_mythe DROP FOREIGN KEY FK_A454F8EC595D5DAB');
        $this->addSql('ALTER TABLE dieu_mythe DROP FOREIGN KEY FK_A454F8ECFB3597B3');
        $this->addSql('DROP TABLE dieu_mythe');
        $this->addSql('ALTER TABLE dieu DROP FOREIGN KEY FK_EAE355B6399BBB13');
        $this->addSql('DROP INDEX UNIQ_EAE355B6399BBB13 ON dieu');
        $this->addSql('ALTER TABLE dieu DROP music_id');
    }
}
