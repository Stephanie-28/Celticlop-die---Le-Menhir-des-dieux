<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260803142746 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dieu_pantheons (dieu_id INT NOT NULL, pantheons_id INT NOT NULL, INDEX IDX_C9AC5BBF595D5DAB (dieu_id), INDEX IDX_C9AC5BBF490E17C6 (pantheons_id), PRIMARY KEY (dieu_id, pantheons_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE dieu_pantheons ADD CONSTRAINT FK_C9AC5BBF595D5DAB FOREIGN KEY (dieu_id) REFERENCES dieu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dieu_pantheons ADD CONSTRAINT FK_C9AC5BBF490E17C6 FOREIGN KEY (pantheons_id) REFERENCES pantheons (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dieu_pantheons DROP FOREIGN KEY FK_C9AC5BBF595D5DAB');
        $this->addSql('ALTER TABLE dieu_pantheons DROP FOREIGN KEY FK_C9AC5BBF490E17C6');
        $this->addSql('DROP TABLE dieu_pantheons');
    }
}
