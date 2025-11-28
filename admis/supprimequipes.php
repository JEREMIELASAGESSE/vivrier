<?php
// Connexion à la base de données
require("../config/config.php");
$pdo = new PDO("mysql:host=localhost;dbname=cacao;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Vérifie que l'ID est présent
if (!isset($_GET['id'])) {
    die("ID utilisateur manquant.");
}

$id = intval($_GET['id']);

// Optionnel : récupérer le chemin de la photo pour la supprimer du serveur
$stmt = $pdo->prepare("SELECT photo FROM utilisateur WHERE id = :id");
$stmt->execute([':id' => $id]);
$utilisateur = $stmt->fetch();

if ($utilisateur && file_exists($utilisateur['photo'])) {
    unlink($utilisateur['photo']); // Supprime le fichier image
}

// Supprime l'utilisateur de la base
$stmt = $pdo->prepare("DELETE FROM utilisateur WHERE id = :id");
$stmt->execute([':id' => $id]);

// Redirection après suppression
header("Location: tbequipes.php");
exit;
