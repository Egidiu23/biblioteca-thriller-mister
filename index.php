<?php
$config = require __DIR__ . '/config.php';

$dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";

try {
    $pdo = new PDO($dsn, $config['user'], $config['pass'], [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    $total = $pdo->query('SELECT COUNT(*) FROM carti')->fetchColumn();

    $carti = $pdo->query(
        'SELECT c.titlu, c.an_aparitie, a.nume AS autor
         FROM carti c
         JOIN autori a ON a.id_autor = c.id_autor
         ORDER BY c.an_aparitie'
    )->fetchAll();
} catch (PDOException $e) {
    http_response_code(500);
    exit('Eroare la conectarea la baza de date: ' . htmlspecialchars($e->getMessage()));
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteca virtuală: Thriller și Mister</title>
</head>
<body>
    <h1>Hello! Conexiunea la baza de date funcționează.</h1>
    <p>În bibliotecă sunt <strong><?= (int) $total ?></strong> cărți.</p>

    <ul>
        <?php foreach ($carti as $carte): ?>
            <li>
                <?= htmlspecialchars($carte['titlu']) ?>
                (<?= htmlspecialchars($carte['autor']) ?>, <?= (int) $carte['an_aparitie'] ?>)
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>