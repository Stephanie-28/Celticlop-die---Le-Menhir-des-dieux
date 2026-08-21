<?php

use App\Service\InitiationPath;

require dirname(__DIR__, 2).'/vendor/autoload.php';

$path = new InitiationPath();
$assert = static function (bool $condition, string $message): void {
    if (!$condition) {
        throw new RuntimeException($message);
    }
};

$expectedLevels = [
    0 => 1, 3 => 1,
    4 => 2, 8 => 2,
    9 => 3, 15 => 3,
    16 => 4, 24 => 4,
    25 => 5, 34 => 5,
    35 => 6, 46 => 6,
    47 => 7, 59 => 7,
    60 => 8, 74 => 8,
    75 => 9, 91 => 9,
    92 => 10, 110 => 10,
    111 => 11, 134 => 11,
    135 => 12,
];

foreach ($expectedLevels as $favoriteCount => $expectedLevel) {
    $actualLevel = $path->forFavoriteCount($favoriteCount)['level'];
    $assert($actualLevel === $expectedLevel, sprintf('%d favoris doivent donner le niveau %d.', $favoriteCount, $expectedLevel));
}

$assert(count($path->all()) === 12, 'Le Chemin doit contenir exactement douze rangs.');
$assert($path->changeDirection(5, 6) === 'up', 'Un niveau supérieur doit déclencher une montée.');
$assert($path->changeDirection(6, 5) === 'down', 'Un niveau inférieur doit déclencher une descente.');
$assert($path->changeDirection(6, 6) === null, 'Un niveau identique ne doit déclencher aucune cérémonie.');

echo "InitiationPath: OK\n";
