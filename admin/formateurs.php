<?php
include '../includes/db.php';

$action = $_GET['action'] ?? '';
$message = '';

if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $description = $_POST['description'] ?? '';
    $photo = $_POST['photo'] ?? '';
    if ($firstName && $lastName) {
        $stmt = $pdo->prepare('INSERT INTO formateur (firstName, lastName, description, photo) VALUES (?, ?, ?, ?)');
        $stmt->execute([$firstName, $lastName, $description, $photo]);
        $message = 'Formateur ajouté avec succès!';
    } else {
        $message = 'Veuillez remplir tous les champs obligatoires.';
    }
}

// Delete trainer
if ($action === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $pdo->prepare('DELETE FROM formateurs WHERE id = ?')->execute([$id]);
    $message = 'Formateur supprimé.';
}

// Fetch all trainers
$formateurs = $pdo->query('SELECT * FROM formateur')->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Gestion des Formateurs</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header>
        <nav class="container">
            <h2>Admin - Formateurs</h2>
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
        <h1>Gestion des Formateurs</h1>
        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <form class="admin-form" method="post" action="?action=add">
            <h3>Ajouter un formateur</h3>
            <label for="firstName">Prénom du formateur :</label>
            <input type="text" name="firstName" id="firstName" required>
            <label for="lastName">Nom du formateur :</label>
            <input type="text" name="lastName" id="lastName" required>
            <label for="description">Description :</label>
            <input type="text" name="description" id="description">
            <label for="photo">Photo (URL ou nom de fichier) :</label>
            <input type="file" name="photo" id="photo">
            <button type="submit">Ajouter</button>
        </form>
        <h3>Liste des formateurs</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Photo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($formateurs as $f): ?>
                    <tr>
                        <td><?= htmlspecialchars($f['id']) ?></td>
                        <td><?= htmlspecialchars($f['firstName']) ?></td>
                        <td><?= htmlspecialchars($f['lastName']) ?></td>
                        <td><?= htmlspecialchars($f['description']) ?></td>
                        <td><img src=<?= htmlspecialchars($f['photo']) ?> alt="" srcset=""></td>
                        <td class="admin-actions">
                            <a href="?action=delete&id=<?= $f['id'] ?>" onclick="return confirm('Supprimer ce formateur ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
