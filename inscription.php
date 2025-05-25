<?php
session_start();
include './includes/db.php';
$action = $_GET['action'] ?? '';
$message = '';
if($action === 'add' && $_SERVER['REQUEST_METHOD'] ==='POST'){
     $username = $_POST['username'] ?? '';
     $email = $_POST['email'] ?? '';
     $password = $_POST['username'] ?? '';
     if ($username && $email && $password) {
        $stmt = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (?,?,?,?)');
        $stmt -> execute([$username, $email, $password]);
        $message = 'vous avez inscris avec success!';
        header('Location: index.php');
     }else{
        $message = 'Veuillez remplir tous les champs obligatoires.';
     }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>

<body>
    <div class="login-box">
    <h2>Inscription</h2>
    <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
    <form>
        <input type="text" name="username" placeholder="Your First name" required autofocus>
        <input type="text" name="email" placeholder=" Email" required autofocus>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">S'inscrire</button>
    </form>
</div>
</body>

</html>