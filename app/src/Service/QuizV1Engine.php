<?php

namespace App\Service;

final class QuizV1Engine
{
    public const QUESTION_COUNT = 14;
    public const ANSWER_COUNT = 4;

    /**
     * @return array<string, array{prompt: string, answers: array<string, array{label: string, scores: array<string, int>}>}>
     */
    public function questions(): array
    {
        return [
            'elements' => $this->question(
                "Parmi ces quatre forces naturelles, laquelle t'attire le plus instinctivement ?",
                [
                    'feu' => ['Le Feu — chaleur, lumière et transformation.', ['Brigid' => 3, 'Taranis' => 2, 'Lugh' => 1]],
                    'eau' => ["L'Eau — mouvement, profondeur et intuition.", ['Manannán mac Lir' => 3, 'Rhiannon' => 2, 'Arianrhod' => 1]],
                    'terre' => ['La Terre — racines, stabilité et nature.', ['Cernunnos' => 3, 'Epona' => 2, 'Sucellus' => 1]],
                    'air' => ["L'Air — liberté, mouvement et inspiration.", ['Arianrhod' => 3, 'Gwydion' => 2, 'Ogmios' => 1]],
                ],
            ),
            'paysage' => $this->question(
                'Un paysage apparaît devant toi. Vers lequel te diriges-tu ?',
                [
                    'foret' => ['Une forêt ancienne où la lumière traverse à peine les arbres.', ['Cernunnos' => 3, 'Nantosuelta' => 2, 'Sucellus' => 1]],
                    'cote' => ['Une côte sauvage battue par les vagues.', ['Manannán mac Lir' => 3, 'Manawydan' => 2, 'Rhiannon' => 1]],
                    'montagne' => ["Une montagne dominant l'horizon.", ['Taranis' => 3, 'Nuada' => 2, 'Macha' => 1]],
                    'clairiere' => ['Une clairière paisible baignée de lumière.', ['Rosmerta' => 3, 'Brigid' => 2, 'Epona' => 1]],
                ],
            ),
            'carrefour' => $this->question(
                "Tu arrives à un carrefour. Aucun signe ne t'indique la bonne direction. Sur quoi te fies-tu ?",
                [
                    'instinct' => ['Mon instinct : quelque chose me dit simplement où aller.', ['Morrigan' => 3, 'Arawn' => 2, 'Macha' => 1]],
                    'reflexion' => ["Ma réflexion : j'observe et je cherche des indices.", ['Gwydion' => 3, 'Ogmios' => 2, 'Nuada' => 1]],
                    'audace' => ['Mon audace : je choisis la voie qui semble la plus difficile.', ['Lugh' => 3, 'Taranis' => 2, 'Macha' => 1]],
                    'curiosite' => ["Ma curiosité : je prends celle dont je sais le moins.", ['Cerridwen' => 3, 'Arianrhod' => 2, 'Dagda' => 1]],
                ],
            ),
            'passage-oublie' => $this->question(
                "Tu découvres un passage que personne ne semble avoir emprunté depuis longtemps. Qu'est-ce qui te pousse à continuer ?",
                [
                    'decouvrir' => ['Découvrir ce qui a été oublié.', ['Arianrhod' => 3, 'Cerridwen' => 2, 'Ogmios' => 1]],
                    'comprendre' => ['Comprendre pourquoi ce passage a été abandonné.', ['Gwydion' => 3, 'Arawn' => 2, 'Morrigan' => 1]],
                    'explorer' => ["Voir jusqu'où il peut me conduire.", ['Manawydan' => 3, 'Manannán mac Lir' => 2, 'Lugh' => 1]],
                    'transmettre' => ['Le rendre praticable pour ceux qui viendront après moi.', ['Sucellus' => 3, 'Nantosuelta' => 2, 'Cernunnos' => 1]],
                ],
            ),
            'obstacle' => $this->question(
                'Un obstacle imprévu bloque ton passage. Quelle est ta première réaction ?',
                [
                    'affronter' => ["Je l'affronte directement.", ['Macha' => 3, 'Taranis' => 2, 'Nuada' => 1]],
                    'autre-voie' => ['Je cherche une autre voie.', ['Manawydan' => 3, 'Manannán mac Lir' => 2, 'Lugh' => 1]],
                    'observer' => ["Je prends le temps d'observer avant d'agir.", ['Arawn' => 3, 'Morrigan' => 2, 'Ogmios' => 1]],
                    'aide' => ["Je cherche de l'aide : certaines épreuves ne doivent pas être affrontées seul.", ['Branwen' => 3, 'Sucellus' => 2, 'Dagda' => 1]],
                ],
            ),
            'responsabilite' => $this->question(
                "On te confie une grande responsabilité. Qu'est-ce qui compte le plus pour toi ?",
                [
                    'justice' => ['Prendre des décisions justes.', ['Nuada' => 3, 'Dagda' => 2, 'Ogmios' => 1]],
                    'protection' => ['Protéger ceux qui comptent sur moi.', ['Nantosuelta' => 3, 'Branwen' => 2, 'Macha' => 1]],
                    'inspirer' => ["Donner aux autres l'envie d'avancer.", ['Lugh' => 3, 'Brigid' => 2, 'Epona' => 1]],
                    'equilibre' => ["Maintenir l'équilibre, même lorsque les choix sont difficiles.", ['Arawn' => 3, 'Cernunnos' => 2, 'Rosmerta' => 1]],
                ],
            ),
            'aider' => $this->question(
                'Une personne vient chercher ton aide. Que lui apportes-tu naturellement ?',
                [
                    'reconfort' => ['Du réconfort et un endroit où reprendre des forces.', ['Nantosuelta' => 3, 'Brigid' => 2, 'Branwen' => 1]],
                    'conseiller' => ["Des conseils pour qu'elle puisse trouver sa propre solution.", ['Ogmios' => 3, 'Gwydion' => 2, 'Dagda' => 1]],
                    'agir' => ["Mon aide immédiate pour affronter le problème avec elle.", ['Macha' => 3, 'Nuada' => 2, 'Taranis' => 1]],
                    'nouveau-regard' => ["Une nouvelle manière de regarder ce qui lui arrive.", ['Cerridwen' => 3, 'Manannán mac Lir' => 2, 'Rhiannon' => 1]],
                ],
            ),
            'porte-mysterieuse' => $this->question(
                "À la tombée de la nuit, une porte apparaît là où il n'y en avait aucune. Qu'espères-tu trouver derrière elle ?",
                [
                    'autre-monde' => ['Quelque chose appartenant à un monde que je ne connais pas.', ['Arawn' => 3, 'Manannán mac Lir' => 2, 'Morrigan' => 1]],
                    'verite' => ['Une vérité oubliée depuis longtemps.', ['Ogmios' => 3, 'Cerridwen' => 2, 'Gwydion' => 1]],
                    'avenir' => ["Une réponse sur ce qui m'attend.", ['Arianrhod' => 3, 'Rhiannon' => 2, 'Branwen' => 1]],
                    'inconnu' => ["Un endroit que personne avant moi n'a découvert.", ['Manawydan' => 3, 'Lugh' => 2, 'Cernunnos' => 1]],
                ],
            ),
            'liens' => $this->question(
                'Au cours de ton voyage, quel lien serais-tu le plus déterminé à préserver ?',
                [
                    'famille' => ["Celui qui m'unit à ma famille.", ['Branwen' => 3, 'Dagda' => 2, 'Nantosuelta' => 1]],
                    'amour' => ["Celui qui m'unit à la personne que j'aime.", ['Rhiannon' => 3, 'Rosmerta' => 2, 'Brigid' => 1]],
                    'amitie' => ["Celui qui m'unit à mes amis.", ['Lugh' => 3, 'Manawydan' => 2, 'Sucellus' => 1]],
                    'communaute' => ["Celui qui m'unit à ma communauté.", ['Sucellus' => 3, 'Epona' => 2, 'Macha' => 1]],
                ],
            ),
            'conflit' => $this->question(
                'Deux personnes auxquelles tu tiens s’opposent. Comment réagis-tu ?',
                [
                    'compromis' => ['Je cherche un compromis acceptable pour les deux.', ['Rosmerta' => 3, 'Branwen' => 2, 'Dagda' => 1]],
                    'juste' => ["Je prends position pour celle que je pense être dans son droit.", ['Nuada' => 3, 'Macha' => 2, 'Taranis' => 1]],
                    'ecouter' => ['J’écoute chacune avant de me prononcer.', ['Branwen' => 3, 'Rhiannon' => 2, 'Epona' => 1]],
                    'origine' => ["Je cherche d'abord à comprendre ce qui a réellement provoqué leur conflit.", ['Gwydion' => 3, 'Cerridwen' => 2, 'Arawn' => 1]],
                ],
            ),
            'transmission' => $this->question(
                'Tu peux laisser quelque chose derrière toi. Que voudrais-tu transmettre ?',
                [
                    'creer' => ["Quelque chose qui donne envie aux autres de créer à leur tour.", ['Brigid' => 3, 'Lugh' => 2, 'Cerridwen' => 1]],
                    'accueillir' => ['Quelque chose qui puisse protéger ou accueillir.', ['Nantosuelta' => 3, 'Branwen' => 2, 'Manawydan' => 1]],
                    'histoire' => ["Une histoire dont on se souviendra.", ['Ogmios' => 3, 'Rhiannon' => 2, 'Gwydion' => 1]],
                    'utile' => ["Quelque chose d'utile qui continuera à servir après mon départ.", ['Sucellus' => 3, 'Dagda' => 2, 'Rosmerta' => 1]],
                ],
            ),
            'changement' => $this->question(
                "Au cours de ton voyage, tu comprends que tu ne pourras pas revenir exactement à la vie que tu avais avant. Comment accueilles-tu cette idée ?",
                [
                    'accepter' => ["Je l'accepte. Certaines choses doivent se terminer pour que d'autres commencent.", ['Morrigan' => 3, 'Cerridwen' => 2, 'Arawn' => 1]],
                    'preserver' => ["Je veux préserver ce qui mérite de l'être, même si le reste doit changer.", ['Nuada' => 3, 'Sucellus' => 2, 'Nantosuelta' => 1]],
                    'devenir' => ["Cela m'inquiète, mais je veux découvrir la personne que je deviendrai.", ['Rhiannon' => 3, 'Arianrhod' => 2, 'Brigid' => 1]],
                    'direction' => ['Cela me réjouit : changer signifie aussi pouvoir choisir une nouvelle direction.', ['Epona' => 3, 'Manawydan' => 2, 'Manannán mac Lir' => 1]],
                ],
            ),
            'qualite' => $this->question(
                "Si les autres ne devaient retenir qu'une seule qualité de toi, laquelle voudrais-tu laisser derrière toi ?",
                [
                    'courage' => ['Mon courage.', ['Taranis' => 3, 'Macha' => 2, 'Nuada' => 1]],
                    'sagesse' => ['Ma sagesse.', ['Dagda' => 3, 'Ogmios' => 2, 'Gwydion' => 1]],
                    'compassion' => ['Ma compassion.', ['Branwen' => 3, 'Rosmerta' => 2, 'Nantosuelta' => 1]],
                    'independance' => ['Mon indépendance.', ['Epona' => 3, 'Manannán mac Lir' => 2, 'Cernunnos' => 1]],
                ],
            ),
            'appel' => $this->question(
                "Une présence ancienne semble t'appeler. Qu'est-ce qui te pousserait à aller vers elle ?",
                [
                    'reconnaissance' => ["L'impression étrange de reconnaître cette présence.", ['Rhiannon' => 3, 'Branwen' => 2, 'Rosmerta' => 1]],
                    'calme' => ['Un sentiment de calme et de confiance.', ['Sucellus' => 3, 'Cernunnos' => 2, 'Nantosuelta' => 1]],
                    'curiosite' => ['Une curiosité impossible à ignorer.', ['Lugh' => 3, 'Manawydan' => 2, 'Cerridwen' => 1]],
                    'destin' => ['La conviction que cette rencontre devait arriver.', ['Arianrhod' => 3, 'Morrigan' => 2, 'Manannán mac Lir' => 1]],
                ],
            ),
        ];
    }

    /**
     * @return array{questionOrder: list<string>, answerOrder: array<string, list<string>>, answers: array<string, string>, current: int}
     */
    public function newAttempt(): array
    {
        $questions = $this->questions();
        $questionOrder = array_keys($questions);
        shuffle($questionOrder);

        $answerOrder = [];
        foreach ($questions as $questionId => $question) {
            $answerIds = array_keys($question['answers']);
            shuffle($answerIds);
            $answerOrder[$questionId] = $answerIds;
        }

        return [
            'questionOrder' => $questionOrder,
            'answerOrder' => $answerOrder,
            'answers' => [],
            'current' => 0,
        ];
    }

    /**
     * @param array{questionOrder: list<string>, answerOrder: array<string, list<string>>, answers: array<string, string>, current: int} $attempt
     *
     * @return array{id: string, prompt: string, answers: list<array{id: string, label: string}>}
     */
    public function publicQuestion(array $attempt, int $position): array
    {
        $questionId = $attempt['questionOrder'][$position] ?? throw new \OutOfBoundsException('Position de question invalide.');
        $question = $this->questions()[$questionId] ?? throw new \LogicException('Question inconnue.');

        $answers = [];
        foreach ($attempt['answerOrder'][$questionId] as $answerId) {
            $answers[] = [
                'id' => $answerId,
                'label' => $question['answers'][$answerId]['label'],
            ];
        }

        return ['id' => $questionId, 'prompt' => $question['prompt'], 'answers' => $answers];
    }

    /**
     * @param array<string, string> $selectedAnswers question ID => answer ID
     *
     * @return array{winner: string, ranking: list<array{name: string, total: int, threeCount: int, twoCount: int}>}
     */
    public function calculate(array $selectedAnswers): array
    {
        $questions = $this->questions();
        if (count($selectedAnswers) !== self::QUESTION_COUNT) {
            throw new \InvalidArgumentException('La tentative doit contenir exactement 14 réponses.');
        }

        $scores = [];
        foreach ($selectedAnswers as $questionId => $answerId) {
            $answer = $questions[$questionId]['answers'][$answerId] ?? null;
            if ($answer === null) {
                throw new \InvalidArgumentException('Une réponse de la tentative est invalide.');
            }

            foreach ($answer['scores'] as $deity => $points) {
                $scores[$deity] ??= ['name' => $deity, 'total' => 0, 'threeCount' => 0, 'twoCount' => 0];
                $scores[$deity]['total'] += $points;
                $scores[$deity]['threeCount'] += $points === 3 ? 1 : 0;
                $scores[$deity]['twoCount'] += $points === 2 ? 1 : 0;
            }
        }

        $ranking = array_values($scores);
        usort($ranking, static function (array $left, array $right): int {
            return $right['total'] <=> $left['total']
                ?: $right['threeCount'] <=> $left['threeCount']
                ?: $right['twoCount'] <=> $left['twoCount']
                ?: strnatcasecmp($left['name'], $right['name']);
        });

        return ['winner' => $ranking[0]['name'], 'ranking' => $ranking];
    }

    /**
     * @return list<string>
     */
    public function deityNames(): array
    {
        $names = [];
        foreach ($this->questions() as $question) {
            foreach ($question['answers'] as $answer) {
                $names = [...$names, ...array_keys($answer['scores'])];
            }
        }

        $names = array_values(array_unique($names));
        natcasesort($names);

        return array_values($names);
    }

    /**
     * @param array<string, array{0: string, 1: array<string, int>}> $answers
     *
     * @return array{prompt: string, answers: array<string, array{label: string, scores: array<string, int>}>}
     */
    private function question(string $prompt, array $answers): array
    {
        $normalized = [];
        foreach ($answers as $id => [$label, $scores]) {
            $normalized[$id] = ['label' => $label, 'scores' => $scores];
        }

        return ['prompt' => $prompt, 'answers' => $normalized];
    }
}
