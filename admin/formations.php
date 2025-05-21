<?php
include '../includes/db.php';

$action = $_GET['action'] ?? '';
$message = '';

if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'] ?? '';
    $domaine = $_POST['domaine'] ?? '';
    $sujet = $_POST['sujet'] ?? '';
    $formateur = $_POST['formateur'] ?? '';
    $date = $_POST['date'] ?? '';
    $prix = $_POST['prix'] ?? '';
    if ($titre && $domaine && $sujet && $formateur && $date && $prix) {
        $stmt = $pdo->prepare('INSERT INTO formations (titre, domaine, sujet, formateur, date, prix) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$titre, $domaine, $sujet, $formateur, $date, $prix]);
        $message = 'Formation ajoutée avec succès!';
    } else {
        $message = 'Veuillez remplir tous les champs.';
    }
}
if ($action === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $pdo->prepare('DELETE FROM formations WHERE id = ?')->execute([$id]);
    $message = 'Formation supprimée.';
}

$formations = $pdo->query('SELECT * FROM formation')->fetchAll(PDO::FETCH_ASSOC);
$domaines = $pdo->query('SELECT * FROM domaine')->fetchAll(PDO::FETCH_ASSOC);
$sujets = $pdo->query('SELECT * FROM sujet')->fetchAll(PDO::FETCH_ASSOC);
$formateurs = $pdo->query('SELECT * FROM formateur')->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Gestion des Formations</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header>
        <nav class="container">
            <h2>Admin - Formations</h2>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="formation.php">Formations</a></li>
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
        <h1>Gestion des Formations</h1>
        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <form class="admin-form" method="post" action="?action=add">
            <h3>Ajouter une formation</h3>
            <label for="titre">Titre :</label>
            <input type="text" name="titre" id="titre" required>
            <label for="domaine">Domaine :</label>
            <select name="domaine" id="domaine" required>
                <option value="">-- Choisir --</option>
                <?php foreach ($domaines as $d): ?>
                    <option value="<?= htmlspecialchars($d['name']) ?>"><?= htmlspecialchars($d['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <label for="sujet">Sujet :</label>
            <select name="sujet" id="sujet" required>
                <option value="">-- Choisir --</option>
                <?php foreach ($sujets as $s): ?>
                    <option value="<?= htmlspecialchars($s['shortDesciption']) ?>"><?= htmlspecialchars($s['shortDesciption']) ?></option>
                <?php endforeach; ?>
            </select>
            <label for="formateur">Formateur :</label>
            <select name="formateur" id="formateur" required>
                <option value="">-- Choisir --</option>
                <?php foreach ($formateurs as $f): ?>
                    <option value="<?= htmlspecialchars($f['firstName']) ?>"><?= htmlspecialchars($f['firstName']) ?></option>
                <?php endforeach; ?>
            </select>
            <label for="date">Date :</label>
            <input type="date" name="date" id="date" required>
            <label for="prix">Prix (€) :</label>
            <input type="number" name="prix" id="prix" min="0" required>
            <button type="submit">Ajouter</button>
        </form>
        <h3>Liste des formations</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Domaine</th>
                    <th>Sujet</th>
                    <th>Formateur</th>
                    <th>Date</th>
                    <th>Prix (€)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($formations as $f): ?>
                    <tr>
                        <td><?= htmlspecialchars($f['id']) ?></td>
                        <td><?= htmlspecialchars($f['titre']) ?></td>
                        <td><?= htmlspecialchars($f['domaine']) ?></td>
                        <td><?= htmlspecialchars($f['sujet']) ?></td>
                        <td><?= htmlspecialchars($f['formateur']) ?></td>
                        <td><?= htmlspecialchars($f['date']) ?></td>
                        <td><?= htmlspecialchars($f['prix']) ?></td>
                        <td class="admin-actions">
                            <a href="?action=delete&id=<?= $f['id'] ?>" onclick="return confirm('Supprimer cette formation ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
