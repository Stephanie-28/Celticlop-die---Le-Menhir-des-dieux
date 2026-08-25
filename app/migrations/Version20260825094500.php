<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260825094500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Réintègre les 17 textes longs et complète quatre dossiers des Archives du Druide.';
    }

    public function up(Schema $schema): void
    {
        $this->updateContents($this->loadContents('archives-long-content.json'));
    }

    public function down(Schema $schema): void
    {
        $this->updateContents($this->loadContents('archives-long-content-rollback.json'));
    }

    /** @return array<string, string> */
    private function loadContents(string $filename): array
    {
        $path = __DIR__.'/data/'.$filename;
        $contents = json_decode((string) file_get_contents($path), true, flags: JSON_THROW_ON_ERROR);

        if (!is_array($contents) || count($contents) !== 21) {
            throw new \RuntimeException(sprintf('Le fichier %s doit contenir exactement 21 textes.', $filename));
        }

        return $contents;
    }

    /** @param array<string, string> $contents */
    private function updateContents(array $contents): void
    {
        foreach ($contents as $title => $content) {
            $updatedRows = $this->connection->executeStatement(
                'UPDATE savoir SET content = :content WHERE title = :title',
                ['content' => $content, 'title' => $title],
            );

            if ($updatedRows !== 1) {
                throw new \RuntimeException(sprintf(
                    'Le Savoir « %s » est absent ou dupliqué : %d ligne(s) mise(s) à jour.',
                    $title,
                    $updatedRows,
                ));
            }
        }
    }
}
