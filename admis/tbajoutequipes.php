<?php
// Connexion à la base de données
require("../config/config.php");

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérification du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Nettoyage des données
    $nom = trim($_POST["nom_U"]);
    $prenom = trim($_POST["prenom_U"]);
    $user = trim($_POST["user"]);
    $mdp = $_POST["password"];
    $contact = trim($_POST["contact_U"]);
    $adresse = trim($_POST["Adresse_U"]);
    $date = $_POST["date"];
    $photo = $_FILES["photo"];

    // Validation simple
    if (
        empty($nom) || empty($prenom) || empty($user) || empty($mdp) ||
        empty($contact) || empty($adresse) || empty($date) || empty($photo["name"])
    ) {
        die("Tous les champs sont obligatoires.");
    }

    if (!preg_match("/^[0-9]{8,15}$/", $contact)) {
        die("Le contact doit contenir entre 8 et 15 chiffres.");
    }

    if (strlen($mdp) < 6) {
        die("Le mot de passe doit contenir au moins 6 caractères.");
    }

    // Hachage du mot de passe
    $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);

    // Téléversement de l'image
    $dossier = "uploads/";
    $nomFichier = uniqid() . "_" . basename($photo["name"]);
    $cheminFichier = $dossier . $nomFichier;

    if (!move_uploaded_file($photo["tmp_name"], $cheminFichier)) {
        die("Erreur lors du téléversement de l'image.");
    }

    // Insertion dans la base
    $sql = "INSERT INTO utilisateur (nom_U, prenom_U, user, password, contact_U, Adresse_U, date, photo)
            VALUES (:nom, :prenom, :user, :mdp, :contact, :adresse, :date, :photo)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":nom" => $nom,
        ":prenom" => $prenom,
        ":user" => $user,
        ":mdp" => $mdp_hash,
        ":contact" => $contact,
        ":adresse" => $adresse,
        ":date" => $date,
        ":photo" => $cheminFichier
    ]);

    echo "Utilisateur ajouté avec succès.";
}
