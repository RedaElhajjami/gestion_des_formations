<?php
// cours.php - Page client pour afficher la liste des cours
include './includes/db.php';

$cours = $pdo->query('SELECT * FROM cours')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Nos Cours – MonEntreprise</title>
  <link rel="stylesheet" href="./assets/style.css">
</head>
<body>
  <header>
    <nav class="container">
      <h2>It Coding</h2>
      <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="formation.php">Formations</a></li>
        <li><a href="cours.php">Cours</a></li>
        <li><a href="calendrier.php">Calendrier</a></li>
        <li><a href="contact.php">Contact</a></li>
        <?php if (isset($_SESSION['username'])): ?>
          <li><span>Bienvenue, <?= htmlspecialchars($_SESSION['username']) ?></span></li>
          <li><a href="logout.php">Déconnexion</a></li>
        <?php else: ?>
          <li><a href="login.php">Connexion</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </header>

  <section class="container">
    <h2>Nos Cours</h2>
    <div class="cards">
      <?php foreach ($cours as $c): ?>
        <div class="card">
          <h3><?= htmlspecialchars($c['name']) ?></h3>
          <p><strong>Sujet :</strong> <?= htmlspecialchars($c['sujet_id']) ?></p>
          <p><strong>Contenu :</strong> <?= htmlspecialchars($c['content']) ?></p>
          <p><strong>Description :</strong> <?= htmlspecialchars($c['description']) ?></p>
          <p><strong>Audience :</strong> <?= htmlspecialchars($c['audience']) ?></p>
          <p><strong>Durée :</strong> <?= htmlspecialchars($c['duration']) ?></p>
          <p><strong>Test inclus :</strong> <?= $c['testIncluded'] ? 'Oui' : 'Non' ?></p>
          <p><strong>Contenu du test :</strong> <?= htmlspecialchars($c['testContent']) ?></p>
          <p><strong>Logo :</strong> <?= htmlspecialchars($c['logo']) ?></p>
        </div>
      <?php endforeach; ?>
      <?php if (empty($cours)): ?>
        <p>Aucun cours disponible pour le moment.</p>
      <?php endif; ?>
    </div>
  </section>
</body>
</html>
