<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/functions.php';

// Numărul total de cărți și ultimele 3 apariții (din baza de date)
$total = (int) $pdo->query('SELECT COUNT(*) FROM carti')->fetchColumn();

$recomandate = $pdo->query(
    'SELECT c.id_carte, c.titlu, c.an_aparitie, c.imagine_coperta, a.nume AS autor
     FROM carti c
     JOIN autori a ON a.id_autor = c.id_autor
     ORDER BY c.an_aparitie DESC
     LIMIT 3'
)->fetchAll();

$genuri = genuri_pe_carte($pdo);

$titlu  = 'Acasă';
$pagina = 'acasa';
require __DIR__ . '/includes/header.php';
?>

<section class="hero">
    <h1>Biblioteca virtuală: Thriller și Mister</h1>
    <p class="lead">
        <?= $total ?> romane care au definit genul, de la clasicii secolului al XIX-lea
        până la bestsellerurile ultimilor ani.
    </p>
    <p><a class="btn" href="colectie.php">Explorează colecția</a></p>
</section>

<section aria-labelledby="titlu-recomandate">
    <h2 id="titlu-recomandate">Cărți recomandate</h2>

    <div class="grila">
        <?php foreach ($recomandate as $carte): ?>
            <?php card_carte($carte, $genuri[$carte['id_carte']] ?? [], 3); ?>
        <?php endforeach; ?>
    </div>

    <p><a class="btn btn-secundar" href="colectie.php">Vezi toată colecția (<?= $total ?> cărți)</a></p>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>