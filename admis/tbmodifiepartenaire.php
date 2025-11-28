<?php
include("../config/config.php");

// Vérifie que l'ID est présent
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Identifiant manquant.";
    exit;
}

$id = $_GET['id'];

// Récupère les données
$stmt = $pdo->prepare("SELECT * FROM partenaire WHERE id = ?");
$stmt->execute([$id]);
$u = $stmt->fetch();

if (!$u) {
    echo "Partenaire introuvable.";
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom_U']);
    $prenom = trim($_POST['prenom_U']);
    $contact = trim($_POST['contact_U']);
    $adresse = trim($_POST['Adresse_U']);
    $date = $_POST['date'];

    // Vérifications
    if (!$nom || !$prenom ||  !$contact || !$adresse || !$date) {
        $errors[] = "Tous les champs doivent être remplis.";
    }


    if (!preg_match('/^\d{10}$/', $contact)) {
        $errors[] = "Le contact doit contenir 10 chiffres.";
    }

    // Gestion de l'image
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        if (!str_starts_with($_FILES['photo']['type'], 'image/')) {
            $errors[] = "Le fichier doit être une image.";
        } else {
            // Supprime l'ancienne image
            if (!empty($u['photo']) && file_exists('uploads/' . $u['photo'])) {
                unlink('uploads/' . $u['photo']);
            }

            $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $photo = uniqid('user_') . '.' . $extension;
            $target = 'uploads/' . $photo;
            move_uploaded_file($_FILES['photo']['tmp_name'], $target);
        }
    } else {
        $photo = $u['photo']; // Conserve l'image existante
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE partenaire SET nom_U=?, prenom_U=?, contact_U=?, Adresse_U=?, date=?, photo=? WHERE id=?");
        $stmt->execute([$nom, $prenom, $contact, $adresse, $date, $photo, $id]);

        header("Location:tbpartenaire.php");
        exit;
    }
}
?>

<!-- Formulaire HTML -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier partenaire</title>
    <link rel="stylesheet" href="../assets/styles/tableau.css">
    <link rel="stylesheet" href="../assets/styles/produit.css">
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

        }

        form {
            background-color: #fff;
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
            margin-top: 0.6rem;
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
            background-color: var(--Rougetomate2);
            color: white;
        }

        td img {
            max-width: 100px;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <form method="post" enctype="multipart/form-data">
        <h1 id="previewContainer">Modifier le partenaire</h1>

        <?php if (!empty($errors)): ?>
            <div style="color:red;">
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <input type="text" name="nom_U" value="<?= htmlspecialchars($u['nom_U']) ?>" required>
        <input type="text" name="prenom_U" value="<?= htmlspecialchars($u['prenom_U']) ?>" required>
        <input type="text" name="contact_U" value="<?= htmlspecialchars($u['contact_U']) ?>" required>
        <input type="text" name="Adresse_U" value="<?= htmlspecialchars($u['Adresse_U']) ?>" required>
        <input type="date" name="date" value="<?= htmlspecialchars($u['date']) ?>" required>
        <p>Photo actuelle :</p>
        <img src="uploads/<?= htmlspecialchars($u['photo']) ?>" width="100"><br>
        <label>Changer la photo :</label>
        <input type="file" name="photo" id="imageInput" accept="image/*"><br><br>
        <input type="submit" value="Mettre à jour">
    </form>
    <script src="../assets/js/equipes.js"></script>
    <script src="../assets/js/tbmembre.js"></script>
</body>

</html>