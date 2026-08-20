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

$attempts = [];
for ($iteration = 0; $iteration < 5; ++$iteration) {
    $attempt = $engine->newAttempt();
    $assert(count(array_unique($attempt['questionOrder'])) === 14, 'Une tentative ne doit contenir aucune question dupliquée.');
    foreach ($attempt['answerOrder'] as $answerOrder) {
        $assert(count($answerOrder) === 4 && count(array_unique($answerOrder)) === 4, 'Les quatre réponses doivent rester uniques.');
    }

    $snapshot = serialize($attempt);
    foreach (array_keys($attempt['questionOrder']) as $position) {
        $publicQuestion = $engine->publicQuestion($attempt, $position);
        $assert(!str_contains(serialize($publicQuestion), 'scores'), 'Le barème ne doit jamais être exposé dans la question publique.');
    }
    $assert(serialize($attempt) === $snapshot, "Consulter une tentative ne doit pas modifier l'ordre établi.");
    $attempts[] = $snapshot;
}
$assert(count(array_unique($attempts)) > 1, 'Une nouvelle tentative doit produire un nouveau mélange.');

$selectedAnswers = [];
foreach ($questions as $questionId => $question) {
    $selectedAnswers[$questionId] = array_key_first($question['answers']);
}

$firstResult = $engine->calculate($selectedAnswers);
$secondResult = $engine->calculate($selectedAnswers);
$assert($firstResult === $secondResult, 'Une même sélection doit toujours produire le même résultat.');
$assert(in_array($firstResult['winner'], $engine->deityNames(), true), 'Le résultat doit être une des 21 divinités autorisées.');

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
