<?php 
    $host = 'localhost';
    $dbname = 'gestion_des_formations';
    $username = 'root';
    $password = '';
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("erreur : " . $e->getMessage());
    }
?>