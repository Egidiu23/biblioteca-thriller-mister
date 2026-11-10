<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/functions.php';

// Filtrele vin din adresa paginii, de exemplu: colectie.php?gen=5&q=fata
$gen = filter_input(INPUT_GET, 'gen', FILTER_VALIDATE_INT) ?: 0;
$q   = trim((string) ($_GET['q'] ?? ''));

$toateGenurile = $pdo->query('SELECT id_gen, nume FROM genuri ORDER BY nume')->fetchAll();

// Interogarea se construiește în funcție de filtrele alese
$sql = 'SELECT c.id_carte, c.titlu, c.an_aparitie, c.imagine_coperta, a.nume AS autor
        FROM carti c
        JOIN autori a ON a.id_autor = c.id_autor
        WHERE 1 = 1';
$parametri = [];

if ($gen > 0) {
    $sql .= ' AND EXISTS (SELECT 1 FROM carti_genuri cg
                          WHERE cg.id_carte = c.id_carte AND cg.id_gen = :gen)';
    $parametri[':gen'] = $gen;
}

if ($q !== '') {
    $sql .= ' AND (c.titlu LIKE :q1 OR a.nume LIKE :q2)';
    $parametri[':q1'] = '%' . $q . '%';
    $parametri[':q2'] = '%' . $q . '%';
}

$sql .= ' ORDER BY c.an_aparitie, c.titlu';

$stmt = $pdo->prepare($sql);
$stmt->execute($parametri);
$carti = $stmt->fetchAll();

$genuri = genuri_pe_carte($pdo);

$titlu  = 'Colecție';
$pagina = 'colectie';
require __DIR__ . '/includes/header.php';
?>

<h1>Colecția de romane</h1>

<form class="filtre" method="get" action="colectie.php">
    <div class="camp">
        <label for="gen">Subgen</label>
        <select id="gen" name="gen">
            <option value="0">Toate subgenurile</option>
            <?php foreach ($toateGenurile as $g): ?>
                <option value="<?= (int) $g['id_gen'] ?>"<?= (int) $g['id_gen'] === $gen ? ' selected' : '' ?>>
                    <?= e($g['nume']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="camp camp-cautare">
        <label for="q">Caută după titlu sau autor</label>
        <input type="search" id="q" name="q" value="<?= e($q) ?>" placeholder="ex.: Christie">
    </div>

    <button class="btn" type="submit">Filtrează</button>
    <a class="btn btn-secundar" href="colectie.php">Resetează</a>
</form>

<p aria-live="polite"><?= count($carti) ?> <?= count($carti) === 1 ? 'carte găsită' : 'cărți găsite' ?></p>

<?php if ($carti): ?>
    <div class="grila">
        <?php foreach ($carti as $carte): ?>
            <?php card_carte($carte, $genuri[$carte['id_carte']] ?? [], 2); ?>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="gol">Nicio carte nu corespunde filtrelor alese. Încearcă altceva sau apasă „Resetează”.</p>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>