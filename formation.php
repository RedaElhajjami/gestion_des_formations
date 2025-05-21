<?php
include './includes/db.php';
$formations = $pdo->query('SELECT * FROM formation')->fetchAll(PDO::FETCH_ASSOC);
$domaines = $pdo->query('SELECT DISTINCT domaine FROM formation')->fetchAll(PDO::FETCH_COLUMN);
$sujets = $pdo->query('SELECT DISTINCT sujet FROM formation')->fetchAll(PDO::FETCH_COLUMN);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Nos Formations – It Coding</title>
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
    <h2>Nos Formations</h2>
    <form method="get" class="filters" style="margin-bottom:2rem;">
      <select name="domaine">
        <option value="">Tous les domaines</option>
        <?php foreach ($domaines as $d): ?>
          <option value="<?= htmlspecialchars($d) ?>" <?= (isset($_GET['domaine']) && $_GET['domaine'] === $d) ? 'selected' : '' ?>><?= htmlspecialchars($d) ?></option>
        <?php endforeach; ?>
      </select>
      <select name="sujet">
        <option value="">Tous les sujets</option>
        <?php foreach ($sujets as $s): ?>
          <option value="<?= htmlspecialchars($s) ?>" <?= (isset($_GET['sujet']) && $_GET['sujet'] === $s) ? 'selected' : '' ?>><?= htmlspecialchars($s) ?></option>
        <?php endforeach; ?>
      </select>
      <button type="submit">Filtrer</button>
    </form>
    <div class="cards">
      <?php
      $filtered = array_filter($formations, function($f) {
        $ok = true;
        if (!empty($_GET['domaine'])) $ok = $ok && $f['domaine'] === $_GET['domaine'];
        if (!empty($_GET['sujet'])) $ok = $ok && $f['sujet'] === $_GET['sujet'];
        return $ok;
      });
      ?>
      <?php foreach ($filtered as $f): ?>
        <div class="card">
          <h3><?= htmlspecialchars($f['titre']) ?></h3>
          <p><strong>Domaine :</strong> <?= htmlspecialchars($f['domaine']) ?></p>
          <p><strong>Sujet :</strong> <?= htmlspecialchars($f['sujet']) ?></p>
          <p><strong>Formateur :</strong> <?= htmlspecialchars($f['formateur']) ?></p>
          <p><strong>Date :</strong> <?= htmlspecialchars($f['date']) ?></p>
          <p><strong>Prix :</strong> <?= htmlspecialchars($f['prix']) ?> €</p>
        </div>
      <?php endforeach; ?>
      <?php if (empty($filtered)): ?>
        <p>Aucune formation trouvée.</p>
      <?php endif; ?>
    </div>
  </section>
</body>
</html>
