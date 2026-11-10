<?php
// Conexiunea la baza de date (PDO). Se include la începutul fiecărei pagini.
$config = require __DIR__ . '/../config.php';

// Ora României (pentru data mesajelor trimise prin formularul de contact)
date_default_timezone_set('Europe/Bucharest');

$dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";

try {
    $pdo = new PDO($dsn, $config['user'], $config['pass'], [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    exit('Eroare la conectarea la baza de date: ' . htmlspecialchars($e->getMessage()));
}