<?php
//conection to database
// Paramètres de connexion
$host = 'localhost';       // Adresse du serveur MySQL
$dbname = 'vivrier'; // Nom de la base de données
$username = 'root';  // Nom d'utilisateur MySQL
$password = ''; // Mot de passe MySQL

try {
    // Création de la connexion avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Configuration des options PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Gestion des erreurs
    echo "Erreur de connexion : " . $e->getMessage();
}
