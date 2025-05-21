<?php
include './includes/db.php';

$formations = $pdo->query('SELECT * FROM formation')->fetchAll(PDO::FETCH_ASSOC);
$calendar = [];
foreach ($formations as $f) {
    $calendar[$f['date']][] = $f;
}

// Obtenir le mois/année à afficher (par défaut mois courant)
$mois = isset($_GET['mois']) ? intval($_GET['mois']) : date('n');
$annee = isset($_GET['annee']) ? intval($_GET['annee']) : date('Y');
$premierJour = mktime(0, 0, 0, $mois, 1, $annee);
$nbJours = date('t', $premierJour);
$debutSemaine = date('N', $premierJour); // 1 (lundi) à 7 (dimanche)

$moisNoms = ['','Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Calendrier des formations – It Coding</title>
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
    <h2>Calendrier des formations</h2>
    <form method="get" style="margin-bottom:1rem;">
      <select name="mois">
        <?php for ($m=1; $m<=12; $m++): ?>
          <option value="<?= $m ?>" <?= $m==$mois?'selected':'' ?>><?= $moisNoms[$m] ?></option>
        <?php endfor; ?>
      </select>
      <select name="annee">
        <?php for ($a=date('Y')-2; $a<=date('Y')+2; $a++): ?>
          <option value="<?= $a ?>" <?= $a==$annee?'selected':'' ?>><?= $a ?></option>
        <?php endfor; ?>
      </select>
      <button type="submit">Voir</button>
    </form>
    <table class="calendar">
      <thead>
        <tr>
          <th>Lun</th><th>Mar</th><th>Mer</th><th>Jeu</th><th>Ven</th><th>Sam</th><th>Dim</th>
        </tr>
      </thead>
      <tbody>
        <tr>
        <?php
        $jour = 1;
        $cell = 1;
        // Cases vides avant le 1er jour du mois
        for ($i=1; $i<$debutSemaine; $i++, $cell++) echo '<td></td>';
        while ($jour <= $nbJours) {
            $dateStr = sprintf('%04d-%02d-%02d', $annee, $mois, $jour);
            echo '<td>' . $jour;
            if (isset($calendar[$dateStr])) {
                foreach ($calendar[$dateStr] as $f) {
                    echo '<div style="background:#e3f2fd;margin:2px 0;padding:2px;border-radius:4px;font-size:0.9em;">'.htmlspecialchars($f['titre']).'</div>';
                }
            }
            echo '</td>';
            if (($cell)%7==0) echo '</tr><tr>';
            $jour++; $cell++;
        }
        // Cases vides après le dernier jour
        while (($cell-1)%7!=0) { echo '<td></td>'; $cell++; }
        ?>
        </tr>
      </tbody>
    </table>
  </section>
</body>
</html>
