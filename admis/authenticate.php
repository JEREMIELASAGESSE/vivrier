<?php
session_start();
require '../config/config.php';

$user = trim($_POST['user']);
$password = trim($_POST['password']);

$stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE user = ?");
$stmt->execute([$user]); // Correction ici : suppression de "params:"
$utilisateur = $stmt->fetch();

if ($utilisateur && password_verify($password, $utilisateur['password'])) {
    $_SESSION['user'] = $utilisateur['user'];
    header("Location: dashboard.php");
    exit;
} else {
    echo "Identifiants incorrects.";
}
