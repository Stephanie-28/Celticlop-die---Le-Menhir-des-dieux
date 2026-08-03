<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260803135231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse ADD reponse_text LONGTEXT NOT NULL, ADD point INT NOT NULL, ADD dieu_id INT NOT NULL');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7595D5DAB FOREIGN KEY (dieu_id) REFERENCES dieu (id)');
        $this->addSql('CREATE INDEX IDX_5FB6DEC7595D5DAB ON reponse (dieu_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7595D5DAB');
        $this->addSql('DROP INDEX IDX_5FB6DEC7595D5DAB ON reponse');
        $this->addSql('ALTER TABLE reponse DROP reponse_text, DROP point, DROP dieu_id');
    }
}
