<?php

use App\Service\QuizV1Engine;
use App\Service\QuizV1Presentation;

require dirname(__DIR__, 2).'/vendor/autoload.php';

$engine = new QuizV1Engine();
$presentation = new QuizV1Presentation();

foreach (array_keys($engine->questions()) as $questionId) {
    if ($presentation->questionHint($questionId) === '') {
        throw new RuntimeException(sprintf('La question %s ne possède pas de texte secondaire.', $questionId));
    }

    $image = $presentation->questionImage($questionId);
    if ($image === null || !is_file(dirname(__DIR__, 2).'/public/'.$image['path']) || $image['alt'] === '') {
        throw new RuntimeException(sprintf('La question %s ne possède pas d’illustration locale accessible.', $questionId));
    }
}

foreach ($engine->deityNames() as $deityName) {
    $traits = $presentation->deityTraits($deityName);
    if (count($traits) !== 3 || count(array_unique($traits)) !== 3) {
        throw new RuntimeException(sprintf('La divinité %s doit posséder exactement trois caractéristiques distinctes.', $deityName));
    }
}

echo "QuizV1Presentation : tous les contenus de présentation sont disponibles.\n";
