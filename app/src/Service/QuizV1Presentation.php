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

    /** @var array<string, array{path: string, alt: string}> */
    private const QUESTION_IMAGES = [
        'elements' => ['path' => 'images/quiz/elements.png', 'alt' => 'Les quatre éléments réunis dans un sanctuaire celtique'],
        'paysage' => ['path' => 'images/quiz/paysage.png', 'alt' => 'Chemins traversant une forêt, une montagne et une côte celtiques'],
        'carrefour' => ['path' => 'images/quiz/carrefour.png', 'alt' => 'Carrefour de chemins marqué par des pierres celtiques'],
        'passage-oublie' => ['path' => 'images/quiz/passage-oublie.png', 'alt' => 'Passage ancien révélé au cœur de ruines celtiques'],
        'obstacle' => ['path' => 'images/quiz/obstacle.png', 'alt' => 'Bouclier et obstacle de pierre sur un chemin ancien'],
        'responsabilite' => ['path' => 'images/quiz/responsabilite.png', 'alt' => 'Épée sacrée et balance celtiques symbolisant la responsabilité'],
        'aider' => ['path' => 'images/quiz/aider.png', 'alt' => 'Offrandes et objets de soin déposés dans un sanctuaire celtique'],
        'porte-mysterieuse' => ['path' => 'images/quiz/porte-mysterieuse.png', 'alt' => 'Porte mystérieuse gravée de motifs celtiques'],
        'liens' => ['path' => 'images/quiz/liens.png', 'alt' => 'Anneaux et entrelacs celtiques symbolisant les liens'],
        'conflit' => ['path' => 'images/quiz/conflit.png', 'alt' => 'Armes celtiques opposées dans une atmosphère de conflit'],
        'transmission' => ['path' => 'images/quiz/transmission.png', 'alt' => 'Pierres oghamiques et manuscrit symbolisant la transmission'],
        'changement' => ['path' => 'images/quiz/changement.png', 'alt' => 'Paysage celtique passant de l’ombre à la lumière'],
        'qualite' => ['path' => 'images/quiz/qualite.png', 'alt' => 'Épée, livre et couronne végétale représentant les qualités intérieures'],
        'appel' => ['path' => 'images/quiz/appel.png', 'alt' => 'Chemin lumineux conduisant vers un horizon celtique inconnu'],
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

    /** @return array{path: string, alt: string}|null */
    public function questionImage(string $questionId): ?array
    {
        return self::QUESTION_IMAGES[$questionId] ?? null;
    }

    /** @return list<string> */
    public function deityTraits(string $deityName): array
    {
        return self::DEITY_TRAITS[$deityName] ?? [];
    }
}
