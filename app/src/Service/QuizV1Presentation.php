<?php

namespace App\Service;

final class QuizV1Presentation
{
    /** @var array<string, string> */
    private const QUESTION_HINTS = [
        'elements' => 'Laisse ton instinct reconnaître la force qui lui ressemble.',
        'paysage' => 'Imagine le chemin qui t’appelle avant même de savoir où il conduit.',
        'carrefour' => 'Lorsque les signes disparaissent, ta manière de choisir révèle ton élan profond.',
        'passage-oublie' => 'Écoute ce qui nourrit ton envie de franchir la limite.',
        'obstacle' => 'Ta première impulsion en dit souvent plus que la solution elle-même.',
        'responsabilite' => 'Choisis la valeur que tu voudrais placer au cœur de tes décisions.',
        'aider' => 'Pense à ce que tu offres spontanément lorsque quelqu’un se tourne vers toi.',
        'porte-mysterieuse' => 'Laisse parler ce que tu espères secrètement découvrir.',
        'liens' => 'Reconnais le lien que tu protégerais malgré la distance et les épreuves.',
        'conflit' => 'Imagine ta réaction avant que la raison ne cherche à la corriger.',
        'transmission' => 'Choisis la trace que tu aimerais voir continuer après toi.',
        'changement' => 'Écoute la façon dont tu accueilles ce qui ne peut plus rester identique.',
        'qualite' => 'Choisis la lumière intérieure que tu voudrais laisser dans les mémoires.',
        'appel' => 'Au terme du voyage, reconnais ce qui te ferait avancer vers l’inconnu.',
    ];

    /** @var array<string, list<string>> */
    private const DEITY_TRAITS = [
        'Dagda' => ['Sagesse', 'Abondance', 'Protection'],
        'Morrigan' => ['Prophétie', 'Courage', 'Transformation'],
        'Lugh' => ['Polyvalence', 'Créativité', 'Courage'],
        'Brigid' => ['Créativité', 'Guérison', 'Inspiration'],
        'Manannán mac Lir' => ['Intuition', 'Protection', 'Mystère'],
        'Macha' => ['Courage', 'Souveraineté', 'Détermination'],
        'Nuada' => ['Justice', 'Autorité', 'Courage'],
        'Rhiannon' => ['Indépendance', 'Loyauté', 'Souveraineté'],
        'Arawn' => ['Sagesse', 'Mystère', 'Justice'],
        'Cerridwen' => ['Transformation', 'Inspiration', 'Sagesse'],
        'Gwydion' => ['Ingéniosité', 'Magie', 'Créativité'],
        'Arianrhod' => ['Destin', 'Indépendance', 'Intuition'],
        'Manawydan' => ['Adaptabilité', 'Loyauté', 'Persévérance'],
        'Branwen' => ['Compassion', 'Paix', 'Loyauté'],
        'Cernunnos' => ['Nature', 'Équilibre', 'Abondance'],
        'Epona' => ['Liberté', 'Protection', 'Fertilité'],
        'Taranis' => ['Puissance', 'Courage', 'Autorité'],
        'Ogmios' => ['Éloquence', 'Sagesse', 'Transmission'],
        'Rosmerta' => ['Générosité', 'Abondance', 'Prospérité'],
        'Nantosuelta' => ['Protection', 'Foyer', 'Fertilité'],
        'Sucellus' => ['Travail', 'Abondance', 'Protection'],
    ];

    public function questionHint(string $questionId): string
    {
        return self::QUESTION_HINTS[$questionId] ?? '';
    }

    /** @return list<string> */
    public function deityTraits(string $deityName): array
    {
        return self::DEITY_TRAITS[$deityName] ?? [];
    }
}
