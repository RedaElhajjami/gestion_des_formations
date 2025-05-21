<?php
include './includes/db.php';
session_start();
$formations = $pdo->query('SELECT * FROM formation ')->fetchAll(PDO::FETCH_ASSOC);
$totalCours = $pdo->query('SELECT COUNT(*) FROM cours')->fetchColumn();
$totalFormations = $pdo->query('SELECT COUNT(*) FROM formation')->fetchColumn();
$satisfaction = 95; 
$reussite = 88;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Accueil – It Coding</title>
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
          <li><span>Bienvenue, <?= htmlspecialchars($_SESSION['username']) ?> </span></li>
          <li><a href="logout.php">Déconnexion</a></li>
        <?php else: ?>
          <li><a href="login.php">Connexion</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </header>

  <section class="hero-section" id="top">
    <div class="hero-overlay">
      <div class="hero-content">
        <div class="hero-text">
          <h6 class="hero-subtitle">Bienvenue sur</h6>
          <h1 class="hero-title">It Coding</h1>
          <p class="hero-description">
            Découvrez nos formations de pointe, en présentiel ou à distance.<br>
            Rejoignez une communauté d'apprenants et de formateurs passionnés.
          </p>
          <div class="cta-button">
            <a href="formation.php" class="cta-link">Voir les Formations</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="features-section">
    <div class="features-wrapper">
      <div class="features-grid">
        <div class="feature-card">
          <div class="feature-icon">
            <img src="assets/images/service-icon-01.png" alt="Education icon">
          </div>
          <div class="feature-content">
            <h3>Formations de Qualité</h3>
            <p>Des parcours adaptés à tous les niveaux, animés par des experts du domaine.</p>
          </div>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <img src="assets/images/service-icon-02.png" alt="Teachers icon">
          </div>
          <div class="feature-content">
            <h3>Formateurs Expérimentés</h3>
            <p>Apprenez auprès de professionnels passionnés et pédagogues.</p>
          </div>
        </div>
        <div class="feature-card">
          <div class="feature-icon">
            <img src="assets/images/service-icon-03.png" alt="Students icon">
          </div>
          <div class="feature-content">
            <h3>Communauté Active</h3>
            <p>Partagez, échangez et progressez avec d'autres apprenants motivés.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="container">
    <h2>Nos formations récentes</h2>
    <div class="gallery">
      <?php 
      $images = [
        'assets/images/course-01.jpg',
        'assets/images/course-02.jpg',
        'assets/images/course-03.jpg',
        'assets/images/course-04.jpg',
        'assets/images/meeting-01.jpg',
        'assets/images/meeting-02.jpg',
        'assets/images/meeting-03.jpg',
        'assets/images/meeting-04.jpg',
      ];
      $i = 0;
      foreach ($formations as $f): ?>
        <div class="card card-with-image">
          <img src="<?= $images[$i % count($images)] ?>" alt="Formation" class="card-img">
          <div class="card-content">
            <h3><?= htmlspecialchars($f['titre']) ?></h3>
            <p><strong>Domaine :</strong> <?= htmlspecialchars($f['domaine']) ?></p>
            <p><strong>Sujet :</strong> <?= htmlspecialchars($f['sujet']) ?></p>
            <p><strong>Date :</strong> <?= htmlspecialchars($f['date']) ?></p>
          </div>
        </div>
      <?php $i++; endforeach; ?>
      <?php if (empty($formations)): ?>
        <p>Aucune formation récente.</p>
      <?php endif; ?>
    </div>
    <div class="metrics">
      <div class="metric">
        <h3><?= $satisfaction ?>%</h3>
        <p>Satisfaction</p>
      </div>
      <div class="metric">
        <h3><?= $reussite ?>%</h3>
        <p>Taux de réussite</p>
      </div>
      <div class="metric">
        <h3><?= $totalCours ?></h3>
        <p>Cours disponibles</p>
      </div>
      <div class="metric">
        <h3><?= $totalFormations ?></h3>
        <p>Formations proposées</p>
      </div>
    </div>
  </section>
</body>
</html>
