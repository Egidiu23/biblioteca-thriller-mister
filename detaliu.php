<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/functions.php';

// Cartea se alege din adresa paginii: detaliu.php?id=3
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$carte = null;
if ($id) {
    $stmt = $pdo->prepare(
        'SELECT c.*, a.nume AS autor, a.tara, a.an_nastere, a.an_deces, a.biografie
         FROM carti c
         JOIN autori a ON a.id_autor = c.id_autor
         WHERE c.id_carte = :id'
    );
    $stmt->execute([':id' => $id]);
    $carte = $stmt->fetch();
}

// Dacă id-ul lipsește sau nu există în baza de date, afișăm eroarea 404
if (!$carte) {
    http_response_code(404);
    $titlu  = 'Cartea nu a fost găsită';
    $pagina = 'colectie';
    require __DIR__ . '/includes/header.php';
    ?>
    <h1>Cartea nu a fost găsită</h1>
    <p>Cartea căutată nu există în colecție.</p>
    <p><a class="btn" href="colectie.php">Înapoi la colecție</a></p>
    <?php
    require __DIR__ . '/includes/footer.php';
    exit;
}

// Genurile cărții (relația N:M prin tabelul carti_genuri)
$stmt = $pdo->prepare(
    'SELECT g.id_gen, g.nume
     FROM genuri g
     JOIN carti_genuri cg ON cg.id_gen = g.id_gen
     WHERE cg.id_carte = :id
     ORDER BY g.nume'
);
$stmt->execute([':id' => $carte['id_carte']]);
$genuriCarte = $stmt->fetchAll();

// Cartea anterioară și cea următoare
$stmt = $pdo->prepare('SELECT id_carte, titlu FROM carti WHERE id_carte < :id ORDER BY id_carte DESC LIMIT 1');
$stmt->execute([':id' => $carte['id_carte']]);
$anterioara = $stmt->fetch();

$stmt = $pdo->prepare('SELECT id_carte, titlu FROM carti WHERE id_carte > :id ORDER BY id_carte ASC LIMIT 1');
$stmt->execute([':id' => $carte['id_carte']]);
$urmatoare = $stmt->fetch();

// Anii autorului: „1821–1881” sau „n. 1940”
if ($carte['an_nastere'] && $carte['an_deces']) {
    $aniAutor = $carte['an_nastere'] . '–' . $carte['an_deces'];
} elseif ($carte['an_nastere']) {
    $aniAutor = 'n. ' . $carte['an_nastere'];
} else {
    $aniAutor = '';
}

$titlu  = $carte['titlu'];
$pagina = 'colectie';
require __DIR__ . '/includes/header.php';
?>

<nav class="firimituri" aria-label="Cale de navigare">
    <ol>
        <li><a href="index.php">Acasă</a></li>
        <li><a href="colectie.php">Colecție</a></li>
        <li aria-current="page"><?= e($carte['titlu']) ?></li>
    </ol>
</nav>

<article class="detaliu">
    <?= coperta_html($carte) ?>

    <div>
        <h1><?= e($carte['titlu']) ?></h1>
        <p class="detaliu-autor">
            <?= e($carte['autor']) ?><?= $aniAutor !== '' ? ' (' . e($aniAutor) . ')' : '' ?>
        </p>

        <?php if ($genuriCarte): ?>
            <p class="etichete">
                <?php foreach ($genuriCarte as $g): ?>
                    <a class="eticheta" href="colectie.php?gen=<?= (int) $g['id_gen'] ?>"><?= e($g['nume']) ?></a>
                <?php endforeach; ?>
            </p>
        <?php endif; ?>

        <h2>Descriere</h2>
        <p><?= $carte['descriere'] ? nl2br(e($carte['descriere'])) : 'Descrierea va fi adăugată în curând.' ?></p>

        <dl class="detalii-lista">
            <dt>An apariție</dt>
            <dd><?= (int) $carte['an_aparitie'] ?></dd>

            <dt>Țara autorului</dt>
            <dd><?= e($carte['tara']) ?></dd>

            <?php if ($carte['nr_pagini']): ?>
                <dt>Număr de pagini</dt>
                <dd><?= (int) $carte['nr_pagini'] ?></dd>
            <?php endif; ?>
        </dl>

        <?php if ($carte['biografie']): ?>
            <h2>Despre autor</h2>
            <p><?= nl2br(e($carte['biografie'])) ?></p>
        <?php endif; ?>
    </div>
</article>

<nav class="navigare-carti" aria-label="Navigare între cărți">
    <?php if ($anterioara): ?>
        <a class="btn btn-secundar" href="detaliu.php?id=<?= (int) $anterioara['id_carte'] ?>">← Cartea anterioară</a>
    <?php else: ?>
        <span></span>
    <?php endif; ?>

    <a class="btn btn-secundar" href="colectie.php">Înapoi la colecție</a>

    <?php if ($urmatoare): ?>
        <a class="btn btn-secundar" href="detaliu.php?id=<?= (int) $urmatoare['id_carte'] ?>">Cartea următoare →</a>
    <?php else: ?>
        <span></span>
    <?php endif; ?>
</nav>

<?php require __DIR__ . '/includes/footer.php'; ?>