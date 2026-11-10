<?php
// Antetul comun: <head>, link de accesibilitate, logo și meniul principal.
// Variabile așteptate din pagină: $titlu (titlul paginii) și $pagina (pagina activă în meniu).
$pagina = $pagina ?? '';
$titlu  = $titlu ?? 'Biblioteca';

$meniu = [
    'acasa'    => ['index.php',    'Acasă'],
    'colectie' => ['colectie.php', 'Colecție'],
    'despre'   => ['despre.php',   'Despre'],
    'contact'  => ['contact.php',  'Contact'],
];
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titlu) ?> | Biblioteca Thriller și Mister</title>
    <meta name="description" content="Expoziție digitală cu romane thriller și mister: colecție, autori și descrieri.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <a class="sari" href="#continut">Sari la conținut</a>

    <header class="antet">
        <div class="container antet-interior">
            <a class="logo" href="index.php">Biblioteca <span>Thriller și Mister</span></a>

            <nav aria-label="Meniu principal">
                <ul class="meniu">
                    <?php foreach ($meniu as $cheie => [$url, $eticheta]): ?>
                        <li>
                            <a href="<?= e($url) ?>"<?= $cheie === $pagina ? ' class="activ" aria-current="page"' : '' ?>><?= e($eticheta) ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main id="continut" class="container">