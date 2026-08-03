<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260803124302 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quiz_result (id INT AUTO_INCREMENT NOT NULL, score INT NOT NULL, created_at DATETIME NOT NULL, user_id INT NOT NULL, quiz_id INT NOT NULL, dieu_id INT DEFAULT NULL, INDEX IDX_FE2E314AA76ED395 (user_id), INDEX IDX_FE2E314A853CD175 (quiz_id), INDEX IDX_FE2E314A595D5DAB (dieu_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE quiz_result ADD CONSTRAINT FK_FE2E314AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE quiz_result ADD CONSTRAINT FK_FE2E314A853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE quiz_result ADD CONSTRAINT FK_FE2E314A595D5DAB FOREIGN KEY (dieu_id) REFERENCES dieu (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_result DROP FOREIGN KEY FK_FE2E314AA76ED395');
        $this->addSql('ALTER TABLE quiz_result DROP FOREIGN KEY FK_FE2E314A853CD175');
        $this->addSql('ALTER TABLE quiz_result DROP FOREIGN KEY FK_FE2E314A595D5DAB');
        $this->addSql('DROP TABLE quiz_result');
    }
}
