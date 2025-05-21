<?php
include '../includes/db.php';

$action = $_GET['action'] ?? '';
$message = '';
if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = $_POST['value'] ?? '';
    if ($value) {
        $stmt = $pdo->prepare('INSERT INTO pays (value) VALUES (?)');
        $stmt->execute([$value]);
        $message = 'Pays ajouté avec succès!';
    } else {
        $message = 'Veuillez remplir le value du pays.';
    }
}

if ($action === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $pdo->prepare('DELETE FROM pays WHERE id = ?')->execute([$id]);
    $message = 'Pays supprimé.';
}
$pays = $pdo->query('SELECT * FROM pays')->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Gestion des Pays</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header>
        <nav class="container">
            <h2>Admin - Pays</h2>
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
        <h1>Gestion des Pays</h1>
        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <form class="admin-form" method="post" action="?action=add">
            <h3>Ajouter un pays</h3>
            <label for="value">value du pays :</label>
            <input type="text" name="value" id="value" required>
            <button type="submit">Ajouter</button>
        </form>
        <h3>Liste des pays</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>value</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pays as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['id']) ?></td>
                        <td><?= htmlspecialchars($p['value']) ?></td>
                        <td class="admin-actions">
                            <a href="?action=delete&id=<?= $p['id'] ?>" onclick="return confirm('Supprimer ce pays ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
