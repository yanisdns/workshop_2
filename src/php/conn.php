<?php
$host = 'localhost';
$dbname = 'wk_2';
$user = 'root';
$pass = 'root';

try {
    $db = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass
    );
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}
