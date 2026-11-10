<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/functions.php';

// Câteva statistici citite din baza de date
$nrCarti   = (int) $pdo->query('SELECT COUNT(*) FROM carti')->fetchColumn();
$nrAutori  = (int) $pdo->query('SELECT COUNT(*) FROM autori')->fetchColumn();
$nrGenuri  = (int) $pdo->query('SELECT COUNT(*) FROM genuri')->fetchColumn();

$titlu  = 'Despre';
$pagina = 'despre';
require __DIR__ . '/includes/header.php';
?>

<h1>Despre expoziție</h1>

<ul class="statistici">
    <li><strong><?= $nrCarti ?></strong> cărți</li>
    <li><strong><?= $nrAutori ?></strong> autori</li>
    <li><strong><?= $nrGenuri ?></strong> subgenuri</li>
</ul>

<div class="text-lung">
    <h2>Despre colecție</h2>
    <p>
        Biblioteca virtuală „Thriller și Mister” este o expoziție digitală dedicată unor romane care
        au influențat genul: de la anchetele clasice ale lui Sherlock Holmes și Hercule Poirot, până la
        thrillerele psihologice care au dominat topurile ultimilor ani. Fiecare carte are o pagină de
        detaliu cu autorul, anul apariției, subgenul și o scurtă descriere.
    </p>

    <h2>Cum este construit site-ul</h2>
    <ul>
        <li><strong>HTML5 semantic:</strong> <code>header</code>, <code>nav</code>, <code>main</code>, <code>section</code>, <code>article</code>, <code>footer</code>.</li>
        <li><strong>CSS responsiv:</strong> layout cu Flexbox și Grid, care se adaptează la telefon, tabletă și desktop.</li>
        <li><strong>PHP și MySQL:</strong> pagina de colecție și cea de detaliu sunt generate din baza de date.</li>
        <li><strong>Git și GitHub:</strong> codul este versionat într-un depozit public.</li>
    </ul>

    <p><a class="btn" href="colectie.php">Explorează colecția</a></p>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>