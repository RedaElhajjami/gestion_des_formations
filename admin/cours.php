<?php
include '../includes/db.php';
$action = $_GET['action'] ?? '';
$message = '';

if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $content = $_POST['content'] ?? '';
    $description = $_POST['description'] ?? '';
    $audience = $_POST['audience'] ?? '';
    $duration = $_POST['duration'] ?? '';
    $testIncluded = isset($_POST['testIncluded']) ? 1 : 0;
    $testContent = $_POST['testContent'] ?? '';
    $logo = $_POST['logo'] ?? '';
    $sujet_id = $_POST['sujet_id'] ?? '';
    if ($name && $sujet_id) {
        $stmt = $pdo->prepare('INSERT INTO cours (name, content, description, audience, duration, testIncluded, testContent, logo, sujet_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$name, $content, $description, $audience, $duration, $testIncluded, $testContent, $logo, $sujet_id]);
        $message = 'Cours ajouté avec succès!';
    } else {
        $message = 'Veuillez remplir au moins le nom et le sujet.';
    }
}
if ($action === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $pdo->prepare('DELETE FROM cours WHERE id = ?')->execute([$id]);
    $message = 'Cours supprimé.';
}

$courses = $pdo->query('SELECT * FROM cours')->fetchAll(PDO::FETCH_ASSOC);
// Fetch all subjects for select
$sujets = $pdo->query('SELECT * FROM sujet')->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Gestion des Cours</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header>
        <nav class="container">
            <h2>Admin - Cours</h2>
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
        <h1>Gestion des Cours</h1>
        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <form class="admin-form" method="post" action="?action=add">
            <h3>Ajouter un cours</h3>
            <label for="name">Nom du cours :</label>
            <input type="text" name="name" id="name" required>
            <label for="content">Contenu :</label>
            <input type="text" name="content" id="content">
            <label for="description">Description :</label>
            <input type="text" name="description" id="description">
            <label for="audience">Audience :</label>
            <input type="text" name="audience" id="audience">
            <label for="duration">Durée :</label>
            <input type="text" name="duration" id="duration">
            <label for="testIncluded">Test inclus :</label>
            <input type="checkbox" name="testIncluded" id="testIncluded" value="1">
            <label for="testContent">Contenu du test :</label>
            <input type="text" name="testContent" id="testContent">
            <label for="logo">Logo (URL ou nom de fichier) :</label>
            <input type="text" name="logo" id="logo">
            <label for="sujet_id">Sujet :</label>
            <select name="sujet_id" id="sujet_id" required>
                <option value="">-- Sélectionner un sujet --</option>
                <?php foreach ($sujets as $s): ?>
                    <option value="<?= htmlspecialchars($s['id']) ?>"><?= htmlspecialchars($s['shortDesciption']) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Ajouter</button>
        </form>
        <h3>Liste des cours</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Contenu</th>
                    <th>Description</th>
                    <th>Audience</th>
                    <th>Durée</th>
                    <th>Test inclus</th>
                    <th>Contenu du test</th>
                    <th>Logo</th>
                    <th>Sujet</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $c): ?>
                    <tr>
                        <td><?= htmlspecialchars($c['id']) ?></td>
                        <td><?= htmlspecialchars($c['name']) ?></td>
                        <td><?= htmlspecialchars($c['content']) ?></td>
                        <td><?= htmlspecialchars($c['description']) ?></td>
                        <td><?= htmlspecialchars($c['audience']) ?></td>
                        <td><?= htmlspecialchars($c['duration']) ?></td>
                        <td><?= $c['testIncluded'] ? 'Oui' : 'Non' ?></td>
                        <td><?= htmlspecialchars($c['testContent']) ?></td>
                        <td><?= htmlspecialchars($c['logo']) ?></td>
                        <td>
                            <?php 
                            $sujet = array_filter($sujets, function($s) use ($c) { return $s['id'] == $c['sujet_id']; });
                            $sujet = reset($sujet);
                            echo $sujet ? htmlspecialchars($sujet['shortDesciption']) : '';
                            ?>
                        </td>
                        <td class="admin-actions">
                            <a href="?action=delete&id=<?= $c['id'] ?>" onclick="return confirm('Supprimer ce cours ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
