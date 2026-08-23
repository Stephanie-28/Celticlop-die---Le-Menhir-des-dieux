<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260823023000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initialise la notoriété historique et culturelle des 102 divinités existantes.';
    }

    public function up(Schema $schema): void
    {
        $levels = [
            5 => ['Brigid', 'Cernunnos', 'Dagda', 'Epona', 'Lugh', 'Morrigan', 'Rhiannon'],
            4 => ['Aengus Óg', 'Balor', 'Danu', 'Macha', 'Manannán mac Lir', 'Nuada', 'Ogme', 'Belenus', 'Esus', 'Matres / Matronae', 'Sucellus', 'Taranis', 'Toutatis', 'Arawn', 'Arianrhod', 'Bran le Béni', 'Cerridwen', 'Gwydion', 'Llew Llaw Gyffes', 'Pwyll', 'Taliesin'],
            3 => ['Áine', 'Airmid', 'Badb', 'Boann', 'Bres', 'Diancecht', 'Ériu', 'Étaín', 'Goibniu', 'Mider', 'Andraste', 'Apollo Grannus', 'Arduinna', 'Artio', 'Belatucadros', 'Belisama', 'Borvo', 'Cailleach', 'Coventina', 'Damona', 'Maponos', 'Nantosuelta', 'Nehalennia', 'Nodens', 'Ogmios', 'Rosmerta', 'Sequana', 'Sulis', 'Blodeuwedd', 'Branwen', 'Don', 'Lludd', 'Manawydan', 'Math fab Mathonwy'],
            2 => ['Banba', 'Cian', 'Fódla', 'Nemain', 'Abellio', 'Acionna', 'Adsullata', 'Alisanos', 'Ambisagrus', 'Andarta', 'Atepomarus', 'Bricta', 'Cathubodua', 'Caturix', 'Cissonius', 'Condatis', 'Dea Matrona', 'Dis Pater', 'Erecura', 'Gobannus', 'Ialonus', 'Leucetios', 'Luxovius', 'Moccus', 'Moritasgus', 'Mullo', 'Nemausus', 'Smertrios', 'Suleviae', 'Vosegus', 'Dylan Eil Ton'],
            1 => ['Abandinus', 'Aereda', 'Artahe', 'Arubianus', 'Bergimus', 'Creidhne', 'Latobius', 'Luchtaine', 'Rudiobus'],
        ];

        foreach ($levels as $level => $names) {
            $quotedNames = implode(', ', array_map(
                fn (string $name): string => $this->connection->quote($name),
                $names,
            ));

            $this->addSql(sprintf('UPDATE dieu SET sacred_level = %d WHERE name IN (%s)', $level, $quotedNames));
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql('UPDATE dieu SET sacred_level = 3');
    }
}
