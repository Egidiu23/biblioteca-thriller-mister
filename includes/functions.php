<?php
// Funcții ajutătoare folosite în mai multe pagini.

// Scapă caracterele speciale HTML (protecție împotriva XSS).
function e($text): string
{
    return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
}

// Returnează genurile fiecărei cărți: [id_carte => [['id_gen' => 1, 'nume' => '...'], ...]]
function genuri_pe_carte(PDO $pdo): array
{
    $rezultat = [];
    $randuri = $pdo->query(
        'SELECT cg.id_carte, g.id_gen, g.nume
         FROM carti_genuri cg
         JOIN genuri g ON g.id_gen = cg.id_gen
         ORDER BY g.nume'
    )->fetchAll();

    foreach ($randuri as $rand) {
        $rezultat[$rand['id_carte']][] = $rand;
    }
    return $rezultat;
}

// Coperta cărții: imaginea din baza de date sau, dacă lipsește, o copertă generată din CSS.
function coperta_html(array $carte): string
{
    if (!empty($carte['imagine_coperta'])) {
        return '<img class="coperta-img" src="' . e($carte['imagine_coperta'])
             . '" alt="Coperta cărții ' . e($carte['titlu']) . '" loading="lazy">';
    }

    $nuante = [350, 18, 215, 160, 275, 40];
    $nuanta = $nuante[((int) $carte['id_carte']) % count($nuante)];

    return '<div class="coperta" style="--nuanta: ' . $nuanta . '" aria-hidden="true">'
         . '<span class="coperta-titlu">' . e($carte['titlu']) . '</span>'
         . '<span class="coperta-autor">' . e($carte['autor']) . '</span>'
         . '</div>';
}

// Cardul unei cărți (folosit pe pagina principală și în colecție).
// $nivel = nivelul titlului (2 => h2, 3 => h3), ca ierarhia titlurilor să rămână corectă.
function card_carte(array $carte, array $genuri = [], int $nivel = 2): void
{
    $url = 'detaliu.php?id=' . (int) $carte['id_carte'];
    $h   = 'h' . $nivel;
    ?>
    <article class="card">
        <?= coperta_html($carte) ?>
        <div class="card-corp">
            <?= "<$h class=\"card-titlu\">" ?><a href="<?= e($url) ?>"><?= e($carte['titlu']) ?></a><?= "</$h>" ?>
            <p class="card-autor"><?= e($carte['autor']) ?> · <?= (int) $carte['an_aparitie'] ?></p>
            <?php if ($genuri): ?>
                <p class="etichete">
                    <?php foreach ($genuri as $gen): ?>
                        <span class="eticheta"><?= e($gen['nume']) ?></span>
                    <?php endforeach; ?>
                </p>
            <?php endif; ?>
            <a class="btn" href="<?= e($url) ?>" aria-label="Detalii despre <?= e($carte['titlu']) ?>">Detalii</a>
        </div>
    </article>
    <?php
}