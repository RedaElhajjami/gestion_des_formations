<?php
include '../includes/db.php';

$action = $_GET['action'] ?? '';
$message = '';
if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = $_POST['value'] ?? '';
    $pays_id = $_POST['pays_id'] ?? '';
    if ($value && $pays_id) {
        $stmt = $pdo->prepare('INSERT INTO ville (value, pays_id) VALUES (?, ?)');
        $stmt->execute([$value, $pays_id]);
        $message = 'Ville ajoutée avec succès!';
    } else {
        $message = 'Veuillez remplir tous les champs.';
    }
}

if ($action === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $pdo->prepare('DELETE FROM ville WHERE id = ?')->execute([$id]);
    $message = 'Ville supprimée.';
}
$villes = $pdo->query('SELECT * FROM ville')->fetchAll(PDO::FETCH_ASSOC);
$pays = $pdo->query('SELECT * FROM pays')->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Gestion des Villes</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header>
        <nav class="container">
            <h2>Admin - Villes</h2>
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
        <h1>Gestion des Villes</h1>
        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <form class="admin-form" method="post" action="?action=add">
            <h3>Ajouter une ville</h3>
            <label for="value">Nom de la ville :</label>
            <input type="text" name="value" id="value" required>
            <label for="pays_id">Pays :</label>
            <select name="pays_id" id="pays_id" required>
                <option value="">-- Sélectionner un pays --</option>
                <?php foreach ($pays as $p): ?>
                    <option value="<?= htmlspecialchars($p['id']) ?>"><?= htmlspecialchars($p['value']) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Ajouter</button>
        </form>
        <h3>Liste des villes</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>value</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($villes as $v): ?>
                    <tr>
                        <td><?= htmlspecialchars($v['id']) ?></td>
                        <td><?= htmlspecialchars($v['value']) ?></td>
                        <td class="admin-actions">
                            <a href="?action=delete&id=<?= $v['id'] ?>" onclick="return confirm('Supprimer cette ville ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
