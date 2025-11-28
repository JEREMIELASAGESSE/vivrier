<?php
// Connexion à la base de données
$pdo = new PDO("mysql:host=localhost;dbname=tomate;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Vérifie que l'ID est présent
if (!isset($_GET['id'])) {
  die("ID utilisateur manquant.");
}

$id = intval($_GET['id']);

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nom = trim($_POST["nom_U"]);
  $prenom = trim($_POST["prenom_U"]);
  $user = trim($_POST["user"]);
  $password = trim($_POST["password"]);
  $contact = trim($_POST["contact_U"]);
  $adresse = trim($_POST["Adresse_U"]);
  $date = $_POST["date"];

  // Gestion de la photo
  $photoPath = null;
  if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] === UPLOAD_ERR_OK) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    if (in_array($_FILES["photo"]["type"], $allowedTypes)) {
      $dossier = "uploads/";
      $nomFichier = uniqid() . "_" . basename($_FILES["photo"]["name"]);
      $cheminFichier = $dossier . $nomFichier;
      if (move_uploaded_file($_FILES["photo"]["tmp_name"], $cheminFichier)) {
        $photoPath = $cheminFichier;
      }
    }
  }

  // Mise à jour avec ou sans nouvelle photo
  if ($photoPath) {
    $sql = "UPDATE utilisateur SET nom_U = :nom, prenom_U = :prenom, user = :user,password =:password ,contact_U = :contact, Adresse_U = :adresse, date = :date, photo = :photo WHERE id = :id";
    $params = [":nom" => $nom, ":prenom" => $prenom, ":user" => $user, ":contact" => $contact, ":adresse" => $adresse, ":date" => $date, ":photo" => $photoPath, ":id" => $id];
  } else {
    $sql = "UPDATE utilisateur SET nom_U = :nom, prenom_U = :prenom, user = :user,password =:password, contact_U = :contact, Adresse_U = :adresse, date = :date WHERE id = :id";
    $params = [":nom" => $nom, ":prenom" => $prenom, ":user" => $user, ":password" => $password, ":contact" => $contact, ":adresse" => $adresse, ":date" => $date, ":id" => $id];
  }

  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);

  header("Location: tbequipes.php");
  exit;
}

// Récupération des données existantes
$stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE id = :id");
$stmt->execute([':id' => $id]);
$utilisateur = $stmt->fetch();

if (!$utilisateur) {
  die("Utilisateur introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Modifier utilisateur</title>
  <link rel="stylesheet" href="../assets/styles/produit.css">
  <link rel="stylesheet" href="../assets/styles/tableau.css">
</head>

<body>
  <style>
    :root {
      --noire-police: #333333;

      --Rougetomate1: #E53935;
      --Rougetomate2: #D32F2F;

      --Vertfeuille1: #388E3C;
      --Vertfeuille2: #4CAF50;

      --Jaunesoleil: #FBC02D;
      --Jaunesoleil2: #FFEB3B;

      --Blanccasse1: #FAFAFA;
      --Blanccasse2: #F5F5F5;

      --Grisdoux: #9E9E9E;
      --Grisfonce: #616161;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: var(--Blanccasse2);
      padding: 20px;
    }

    form {
      background-color: var(--Blanccasse1);
      padding: 30px;
      max-width: 650px;
      margin: auto;
      border-radius: 15px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      margin-bottom: 2px;
      color: var(--Grisdoux);
      font-size: 2.5rem;
    }

    input[type="text"],
    input[type="date"],
    input[type="file"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 10px 0 0 10px;
      /* Bord gauche arrondi */
    }

    input[type="submit"] {
      width: 100%;
      padding: 12px;
      background-color: var(--Vertfeuille1);
      color: white;
      border: none;
      border-radius: 0 20px 20px 0;
      /* Bord droit arrondi */
      font-size: 15px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
      background-color: var(--Vertfeuille2);
    }

    #previewContainer {
      max-width: 650px;
      max-height: 250px;
    }

    #previewContainer img {
      max-height: 240px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: #ffffff;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    th,
    td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: center;
    }

    th {
      background-color: var(--Rougetomate1);
      color: white;
    }

    td img {
      max-width: 100px;
      border-radius: 4px;
    }
  </style>
  <h1>Modifier l'utilisateur</h1>
  <form method="post" enctype="multipart/form-data">
    <input type="text" name="nom_U" value="<?= htmlspecialchars($utilisateur['nom_U']) ?>" required>
    <input type="text" name="prenom_U" value="<?= htmlspecialchars($utilisateur['prenom_U']) ?>" required>
    <input type="text" name="user" value="<?= htmlspecialchars($utilisateur['user']) ?>" required>
    <input type="text" name="password" value="<?= htmlspecialchars($utilisateur['password']) ?>" required>
    <input type="text" name="contact_U" value="<?= htmlspecialchars($utilisateur['contact_U']) ?>" required>
    <input type="text" name="Adresse_U" value="<?= htmlspecialchars($utilisateur['Adresse_U']) ?>" required>
    <input type="date" name="date" value="<?= htmlspecialchars($utilisateur['date']) ?>" required>
    <p>Photo actuelle :</p>
    <img src="<?= htmlspecialchars($utilisateur['photo']) ?>" width="100"><br><br>
    <label>Changer la photo :</label>
    <input type="file" name="photo" accept="image/*"> <br><br>
    <input type="submit" value="Enregistrer les modifications">
  </form>
</body>

</html>