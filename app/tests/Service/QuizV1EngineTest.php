<?php

use App\Service\QuizV1Engine;

require dirname(__DIR__, 2).'/vendor/autoload.php';

$engine = new QuizV1Engine();
$questions = $engine->questions();

$assert = static function (bool $condition, string $message): void {
    if (!$condition) {
        throw new RuntimeException($message);
    }
};

$assert(count($questions) === 14, 'Le Quiz doit contenir exactement 14 questions.');
foreach ($questions as $questionId => $question) {
    $assert(count($question['answers']) === 4, sprintf('La question %s doit contenir exactement 4 réponses.', $questionId));
    foreach ($question['answers'] as $answer) {
        $assert(array_values($answer['scores']) === [3, 2, 1], 'Chaque réponse doit attribuer exactement +3, +2 et +1.');
    }
}

$assert(count($engine->deityNames()) === 21, 'Le Quiz doit proposer exactement 21 divinités distinctes.');

$expectedQuestionOrder = [
    'elements',
    'paysage',
    'carrefour',
    'passage-oublie',
    'obstacle',
    'responsabilite',
    'aider',
    'porte-mysterieuse',
    'liens',
    'conflit',
    'transmission',
    'changement',
    'qualite',
    'appel',
];

$answerOrders = [];
for ($iteration = 0; $iteration < 5; ++$iteration) {
    $attempt = $engine->newAttempt();
    $assert(count(array_unique($attempt['questionOrder'])) === 14, 'Une tentative ne doit contenir aucune question dupliquée.');
    $assert($attempt['questionOrder'] === $expectedQuestionOrder, "L'ordre narratif des 14 questions doit rester identique à chaque tentative.");
    $assert($engine->publicQuestion($attempt, 0)['id'] === 'elements', 'La première question doit toujours être ÉLÉMENTS.');
    $assert($engine->publicQuestion($attempt, 13)['id'] === 'appel', 'La dernière question doit toujours être APPEL.');
    foreach ($attempt['answerOrder'] as $answerOrder) {
        $assert(count($answerOrder) === 4 && count(array_unique($answerOrder)) === 4, 'Les quatre réponses doivent rester uniques.');
    }

    $snapshot = serialize($attempt);
    foreach (array_keys($attempt['questionOrder']) as $position) {
        $publicQuestion = $engine->publicQuestion($attempt, $position);
        $assert(!str_contains(serialize($publicQuestion), 'scores'), 'Le barème ne doit jamais être exposé dans la question publique.');
    }
    $assert(serialize($attempt) === $snapshot, "Consulter une tentative ne doit pas modifier l'ordre établi.");
    $attempt['answers']['elements'] = 'feu';
    $engine->publicQuestion($attempt, 1);
    $engine->publicQuestion($attempt, 0);
    $assert($attempt['answers']['elements'] === 'feu', 'Revenir à une question précédente doit conserver la réponse sélectionnée.');
    $answerOrders[] = serialize($attempt['answerOrder']);
}
$assert(count(array_unique($answerOrders)) > 1, 'Une nouvelle tentative doit produire un nouveau mélange des réponses.');
$assert($engine->newAttempt()['answers'] === [], 'Une nouvelle tentative doit remettre les réponses à zéro.');

$selectedAnswers = [];
foreach ($questions as $questionId => $question) {
    $selectedAnswers[$questionId] = array_key_first($question['answers']);
}

$firstResult = $engine->calculate($selectedAnswers);
$secondResult = $engine->calculate($selectedAnswers);
$assert($firstResult === $secondResult, 'Une même sélection doit toujours produire le même résultat.');
$assert(in_array($firstResult['winner'], $engine->deityNames(), true), 'Le résultat doit être une des 21 divinités autorisées.');

$tieBrokenByThree = [
    'elements' => 'air', 'paysage' => 'foret', 'carrefour' => 'reflexion',
    'passage-oublie' => 'decouvrir', 'obstacle' => 'affronter', 'responsabilite' => 'equilibre',
    'aider' => 'reconfort', 'porte-mysterieuse' => 'avenir', 'liens' => 'communaute',
    'conflit' => 'origine', 'transmission' => 'accueillir', 'changement' => 'direction',
    'qualite' => 'sagesse', 'appel' => 'calme',
];
$threeResult = $engine->calculate($tieBrokenByThree);
$assert($threeResult['winner'] === 'Arianrhod', "Le nombre de +3 doit départager l'égalité de score total.");
$gwyddionIndex = array_search('Gwydion', array_column($threeResult['ranking'], 'name'), true);
$nantosueltaIndex = array_search('Nantosuelta', array_column($threeResult['ranking'], 'name'), true);
$assert(is_int($gwyddionIndex) && is_int($nantosueltaIndex) && $gwyddionIndex < $nantosueltaIndex, 'Une égalité parfaite doit être départagée alphabétiquement.');

$tieBrokenByTwo = [
    'elements' => 'feu', 'paysage' => 'clairiere', 'carrefour' => 'curiosite',
    'passage-oublie' => 'explorer', 'obstacle' => 'observer', 'responsabilite' => 'equilibre',
    'aider' => 'nouveau-regard', 'porte-mysterieuse' => 'inconnu', 'liens' => 'amour',
    'conflit' => 'ecouter', 'transmission' => 'utile', 'changement' => 'direction',
    'qualite' => 'independance', 'appel' => 'calme',
];
$assert($engine->calculate($tieBrokenByTwo)['winner'] === 'Manawydan', "Le nombre de +2 doit départager l'égalité après les +3.");

for ($index = 1, $count = count($firstResult['ranking']); $index < $count; ++$index) {
    $previous = $firstResult['ranking'][$index - 1];
    $current = $firstResult['ranking'][$index];
    if ($previous['total'] === $current['total']) {
        $assert($previous['threeCount'] >= $current['threeCount'], 'Une égalité doit être départagée par le nombre de +3.');
    }
    if ($previous['total'] === $current['total'] && $previous['threeCount'] === $current['threeCount']) {
        $assert($previous['twoCount'] >= $current['twoCount'], 'Une égalité persistante doit être départagée par le nombre de +2.');
    }
    if ($previous['total'] === $current['total'] && $previous['threeCount'] === $current['threeCount'] && $previous['twoCount'] === $current['twoCount']) {
        $assert(strnatcasecmp($previous['name'], $current['name']) <= 0, 'Le dernier départage doit être alphabétique et déterministe.');
    }
}

$invalidAnswers = $selectedAnswers;
array_pop($invalidAnswers);
try {
    $engine->calculate($invalidAnswers);
    throw new RuntimeException('Une tentative incomplète ne doit pas être calculée.');
} catch (InvalidArgumentException) {
}

echo "QuizV1Engine : tous les contrôles sont validés.\n";
