<?php

$host = "database";
$dbname = "le_menhir_des_dieux";
$user = "root";
$password = "root";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $password
    );

    echo "<h1>Connexion à MySQL réussie ! 🎉</h1>";
} catch (PDOException $e) {
    echo "<h1>Erreur de connexion</h1>";
    echo $e->getMessage();
}
