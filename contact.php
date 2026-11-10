<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/functions.php';

$erori = [];
$nume = $email = $mesaj = '';

// Formularul se prelucrează ÎNAINTE de orice afișare (altfel redirecționarea nu mai funcționează)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nume  = trim((string) ($_POST['nume'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $mesaj = trim((string) ($_POST['mesaj'] ?? ''));

    if ($nume === '' || mb_strlen($nume) > 100) {
        $erori[] = 'Completează numele (maximum 100 de caractere).';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 150) {
        $erori[] = 'Introdu o adresă de email validă.';
    }
    if ($mesaj === '') {
        $erori[] = 'Scrie un mesaj.';
    }

    if (!$erori) {
        $stmt = $pdo->prepare(
            'INSERT INTO contact_mesaje (nume, email, mesaj, data_trimiterii)
             VALUES (:nume, :email, :mesaj, :data)'
        );
        $stmt->execute([
            ':nume'  => $nume,
            ':email' => $email,
            ':mesaj' => $mesaj,
            ':data'  => date('Y-m-d H:i:s'),
        ]);

        // Redirecționăm, ca mesajul să nu se retrimită la reîncărcarea paginii
        header('Location: contact.php?trimis=1');
        exit;
    }
}

$trimis = isset($_GET['trimis']);

$titlu  = 'Contact';
$pagina = 'contact';
require __DIR__ . '/includes/header.php';
?>

<h1>Contact</h1>
<p>Ai o întrebare sau o sugestie? Scrie-ne și îți răspundem cât de repede putem.</p>

<?php if ($trimis): ?>
    <p class="alerta alerta-ok" role="status">Mulțumim! Mesajul tău a fost trimis.</p>
<?php endif; ?>

<?php if ($erori): ?>
    <div class="alerta alerta-eroare" role="alert">
        <strong>Mesajul nu a fost trimis:</strong>
        <ul>
            <?php foreach ($erori as $eroare): ?>
                <li><?= e($eroare) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form class="formular" method="post" action="contact.php">
    <div class="camp">
        <label for="nume">Nume</label>
        <input type="text" id="nume" name="nume" maxlength="100" required value="<?= e($nume) ?>">
    </div>

    <div class="camp">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" maxlength="150" required value="<?= e($email) ?>">
    </div>

    <div class="camp">
        <label for="mesaj">Mesaj</label>
        <textarea id="mesaj" name="mesaj" required><?= e($mesaj) ?></textarea>
    </div>

    <div>
        <button class="btn" type="submit">Trimite mesajul</button>
    </div>
</form>

<?php require __DIR__ . '/includes/footer.php'; ?>
