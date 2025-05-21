<?php
include '../includes/db.php';

$action = $_GET['action'] ?? '';
$message = '';
if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $shortDesciption = $_POST['shortDesciption'] ?? '';
    $longDesciption = $_POST['longDesciption'] ?? '';
    $individualBenifit = $_POST['individualBenifit'] ?? '';
    $businessBenifit = $_POST['businessBenifit'] ?? '';
    $logo = $_POST['logo'] ?? '';
    $domaine_id = $_POST['domaine_id'] ?? null;
    if ($shortDesciption) {
        $stmt = $pdo->prepare('INSERT INTO sujet (shortDesciption, longDesciption, individualBenifit, businessBenifit, logo, domaine_id) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$shortDesciption, $longDesciption, $individualBenifit, $businessBenifit, $logo, $domaine_id]);
        $message = 'Sujet ajouté avec succès!';
    } else {
        $message = 'Veuillez remplir la description courte du sujet.';
    }
}
if ($action === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $pdo->prepare('DELETE FROM sujet WHERE id = ?')->execute([$id]);
    $message = 'Sujet supprimé.';
}
$sujets = $pdo->query('SELECT * FROM sujet')->fetchAll(PDO::FETCH_ASSOC);
// Fetch all domains for select
$domaines = $pdo->query('SELECT * FROM domaine')->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Gestion des Sujets</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header>
        <nav class="container">
            <h2>Admin - Sujets</h2>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="formations.php">Formations</a></li>
                <li><a href="cours.php">Cours</a></li>
                <li><a href="sujets.php">Sujets</a></li>
                <li><a href="domains.php">Domaines</a></li>
                <li><a href="formateurs.php">Formateurs</a></li>
                <li><a href="pays.php">Pays</a></li>
                <li><a href="villes.php">Villes</a></li>
                <li><a href="../logout.php" class="logout-btn">Déconnexion</a></li>
            </ul>
        </nav>
    </header>
    <main class="container">
        <h1>Gestion des Sujets</h1>
        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <form class="admin-form" method="post" action="?action=add">
            <h3>Ajouter un sujet</h3>
            <label for="shortDesciption">Description courte :</label>
            <input type="text" name="shortDesciption" id="shortDesciption" required>
            <label for="longDesciption">Description longue :</label>
            <input type="text" name="longDesciption" id="longDesciption">
            <label for="individualBenifit">Bénéfice individuel :</label>
            <input type="text" name="individualBenifit" id="individualBenifit">
            <label for="businessBenifit">Bénéfice entreprise :</label>
            <input type="text" name="businessBenifit" id="businessBenifit">
            <label for="logo">Logo (URL ou nom de fichier) :</label>
            <input type="text" name="logo" id="logo">
            <label for="domaine_id">Domaine :</label>
            <select name="domaine_id" id="domaine_id">
                <option value="">-- Sélectionner un domaine --</option>
                <?php foreach ($domaines as $d): ?>
                    <option value="<?= htmlspecialchars($d['id']) ?>"><?= htmlspecialchars($d['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Ajouter</button>
        </form>
        <h3>Liste des sujets</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Description courte</th>
                    <th>Description longue</th>
                    <th>Bénéfice individuel</th>
                    <th>Bénéfice entreprise</th>
                    <th>Logo</th>
                    <th>ID Domaine</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sujets as $s): ?>
                    <tr>
                        <td><?= htmlspecialchars($s['id']) ?></td>
                        <td><?= htmlspecialchars($s['shortDesciption']) ?></td>
                        <td><?= htmlspecialchars($s['longDesciption']) ?></td>
                        <td><?= htmlspecialchars($s['individualBenifit']) ?></td>
                        <td><?= htmlspecialchars($s['businessBenifit']) ?></td>
                        <td><?= htmlspecialchars($s['logo']) ?></td>
                        <td><?= htmlspecialchars($s['domaine_id']) ?></td>
                        <td class="admin-actions">
                            <a href="?action=delete&id=<?= $s['id'] ?>" onclick="return confirm('Supprimer ce sujet ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
