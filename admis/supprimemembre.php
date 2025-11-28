<?php
include("../config/config.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Identifiant manquant.";
    exit;
}

$id = $_GET['id'];

// Récupère l'utilisateur
$stmt = $pdo->prepare("SELECT photo FROM equipes WHERE id = ?");
$stmt->execute([$id]);
$u = $stmt->fetch();

if ($u) {
    // Supprime l'image
    if (!empty($u['photo']) && file_exists('uploads/' . $u['photo'])) {
        unlink('uploads/' . $u['photo']);
    }

    // Supprime l'utilisateur
    $stmt = $pdo->prepare("DELETE FROM equipes WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: tbmembre.php");
exit;
