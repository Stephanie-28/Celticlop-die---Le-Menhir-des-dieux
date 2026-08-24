<?php

namespace App\Enum;

enum SavoirEditorialType: string
{
    case OFFICIEL = 'officiel';
    case DECOUVERTE = 'decouverte';
    case DOSSIER = 'dossier';

    public function label(): string
    {
        return match ($this) {
            self::OFFICIEL => 'Savoir officiel',
            self::DECOUVERTE => 'Découverte documentaire',
            self::DOSSIER => 'Dossier des Archives',
        };
    }
}
