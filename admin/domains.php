<?php
include '../includes/db.php';

$action = $_GET['action'] ?? '';
$message = '';
if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    if ($name) {
        $stmt = $pdo->prepare('INSERT INTO domaine (name, description) VALUES (?, ?)');
        $stmt->execute([$name, $description]);
        $message = 'Domaine ajouté avec succès!';
    } else {
        $message = 'Veuillez remplir le name du domaine.';
    }
}
if ($action === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $pdo->prepare('DELETE FROM domaine WHERE id = ?')->execute([$id]);
    $message = 'Domaine supprimé.';
}
$domains = $pdo->query('SELECT * FROM domaine')->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Gestion des Domaines</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header>
        <nav class="container">
            <h2>Admin - Domaines</h2>
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
        <h1>Gestion des Domaines</h1>
        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <form class="admin-form" method="post" action="?action=add">
            <h3>Ajouter un domaine</h3>
            <label for="name">name du domaine :</label>
            <input type="text" name="name" id="name" required>
            <label for="description">Description :</label>
            <input type="text" name="description" id="description">
            <button type="submit">Ajouter</button>
        </form>
        <h3>Liste des domaines</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($domains as $d): ?>
                    <tr>
                        <td><?= htmlspecialchars($d['id']) ?></td>
                        <td><?= htmlspecialchars($d['name']) ?></td>
                        <td><?= htmlspecialchars($d['description']) ?></td>
                        <td class="admin-actions">
                            <a href="?action=delete&id=<?= $d['id'] ?>" onclick="return confirm('Supprimer ce domaine ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
