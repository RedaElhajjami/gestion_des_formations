<?php
include '../includes/db.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <header>
        <nav class="container">
            <h2>Admin - Dashboard</h2>
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
        <h1>Bienvenue sur le tableau de bord administrateur</h1>
        <div class="admin-nav">
            <ul>
                <li><a href="formations.php">Gérer les Formations</a></li>
                <li><a href="cours.php">Gérer les Cours</a></li>
                <li><a href="sujets.php">Gérer les Sujets</a></li>
                <li><a href="domains.php">Gérer les Domaines</a></li>
                <li><a href="formateurs.php">Gérer les Formateurs</a></li>
                <li><a href="pays.php">Gérer les Pays</a></li>
                <li><a href="villes.php">Gérer les Villes</a></li>
            </ul>
        </div>
        <div class="dashboard-cards">
            <div class="dashboard-card">
                <h2>Formations</h2>
                <p>Ajouter, modifier ou supprimer des formations.</p>
            </div>
            <div class="dashboard-card">
                <h2>Cours</h2>
                <p>Gérer les cours proposés.</p>
            </div>
            <div class="dashboard-card">
                <h2>Formateurs</h2>
                <p>Gérer les formateurs et intervenants.</p>
            </div>
        </div>
    </main>
</body>
</html>
