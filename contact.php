<?php
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $msg = trim($_POST['message'] ?? '');
    if ($nom && $email && $msg) {
        $message = 'Merci pour votre message, ' . htmlspecialchars($nom) . ' ! Nous vous répondrons rapidement.';
    } else {
        $message = 'Merci de remplir tous les champs.';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Contact – It Coding</title>
  <link rel="stylesheet" href="./assets/style.css">
</head>
<body>
  <header>
    <nav class="container">
      <h2>It Coding</h2>
      <ul>
        <li><a href="">Accueil</a></li>
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
    <h2>Nous contacter</h2>
    <?php if ($message): ?>
      <div class="message" style="margin-bottom:1rem; color:green;">
        <?= $message ?>
      </div>
    <?php endif; ?>
    <form method="POST" action="">
      <div class="form-group">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>
      </div>
      <div class="form-group">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="message">Message :</label>
        <textarea id="message" name="message" rows="5" required></textarea>
      </div>
      <button type="submit">Envoyer</button>
    </form>
  </section>
</body>
</html>
