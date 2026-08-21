<?php

namespace App\Service;

final class InitiationPath
{
    /**
     * @var list<array{level: int, title: string, meaning: string, minimum: int, maximum: ?int}>
     */
    private const RANKS = [
        ['level' => 1, 'title' => 'Chercheur de Secrets', 'meaning' => 'Tu fais tes premiers pas à travers les mystères et les récits oubliés.', 'minimum' => 0, 'maximum' => 3],
        ['level' => 2, 'title' => 'Apprenti des Brumes', 'meaning' => "Tu avances au-delà des brumes et commences à distinguer les secrets de l'ancien monde.", 'minimum' => 4, 'maximum' => 8],
        ['level' => 3, 'title' => 'Disciple du Sanctuaire', 'meaning' => 'Ta curiosité devient connaissance et ton chemin au sein du Sanctuaire commence réellement.', 'minimum' => 9, 'maximum' => 15],
        ['level' => 4, 'title' => 'Chroniqueur', 'meaning' => 'Les récits anciens te deviennent familiers et tu commences à en préserver la mémoire.', 'minimum' => 16, 'maximum' => 24],
        ['level' => 5, 'title' => 'Maître des Chroniques', 'meaning' => 'Mythes, êtres et symboles forment désormais entre tes mains une mémoire que tu sais parcourir.', 'minimum' => 25, 'maximum' => 34],
        ['level' => 6, 'title' => 'Ascendant Druide', 'meaning' => 'Tu dépasses la simple connaissance et commences ton ascension vers la sagesse druidique.', 'minimum' => 35, 'maximum' => 46],
        ['level' => 7, 'title' => 'Maître Ascendant', 'meaning' => "Ton ascension t'a conduit à une compréhension profonde des traditions et de leurs mystères.", 'minimum' => 47, 'maximum' => 59],
        ['level' => 8, 'title' => 'Esprit Éveillé', 'meaning' => 'Ton regard dépasse désormais le monde visible et perçoit les liens qui unissent les anciens savoirs.', 'minimum' => 60, 'maximum' => 74],
        ['level' => 9, 'title' => 'Élu des Dieux', 'meaning' => "Ton chemin t'a rapproché des puissances divines dont tu as appris à reconnaître les traces et les récits.", 'minimum' => 75, 'maximum' => 91],
        ['level' => 10, 'title' => 'Gardien des Légendes', 'meaning' => 'Tu ne découvres plus seulement les légendes : tu participes symboliquement à la préservation de leur mémoire.', 'minimum' => 92, 'maximum' => 110],
        ['level' => 11, 'title' => 'Sage de l’Émeraude', 'meaning' => "Ton long voyage à travers les traditions celtiques t'a conduit à l'un des plus hauts degrés de connaissance.", 'minimum' => 111, 'maximum' => 134],
        ['level' => 12, 'title' => 'Archidruide Céleste', 'meaning' => "Tu as parcouru l'ensemble du chemin initiatique et atteint le rang ultime de Celticlopédie.", 'minimum' => 135, 'maximum' => null],
    ];

    /**
     * @return list<array{level: int, title: string, meaning: string, minimum: int, maximum: ?int}>
     */
    public function all(): array
    {
        return self::RANKS;
    }

    /**
     * @return array{level: int, title: string, meaning: string, minimum: int, maximum: ?int}
     */
    public function forFavoriteCount(int $favoriteCount): array
    {
        foreach (array_reverse(self::RANKS) as $rank) {
            if ($favoriteCount >= $rank['minimum']) {
                return $rank;
            }
        }

        return self::RANKS[0];
    }
}
