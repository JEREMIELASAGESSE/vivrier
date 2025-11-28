<?php
include("../config/config.php");

// Vérifie que l'ID est présent dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Erreur : identifiant du produit manquant.";
    exit;
}

$id = $_GET['id'];

// Récupère les données du produit
$stmt = $pdo->prepare("SELECT * FROM produits WHERE id = ?");
$stmt->execute([$id]);
$produit = $stmt->fetch();

if (!$produit) {
    echo "Produit introuvable.";
    exit;
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom_produit'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    // Gestion de l'image
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photo = $_FILES['photo']['name'];
        $target = 'uploads/' . basename($photo);
        move_uploaded_file($_FILES['photo']['tmp_name'], $target);
    } else {
        $photo = $produit['photo']; // Conserve l'image existante
    }

    // Mise à jour en base
    $stmt = $pdo->prepare("UPDATE produits SET nom_produit=?, description=?, date=?, photo=? WHERE id=?");
    $stmt->execute([$nom, $description, $date, $photo, $id]);

    // Redirection
    header("Location: tbproduits.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier le produit</title>
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
            padding: 20px;
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
            margin-bottom: 5px;
            color: var(--Grisdoux);
        }

        input[type="text"],
        input[type="date"],
        input[type="file"] {
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

        #affiche_produit {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 30px;
        }

        .cart-produit {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 300px;
            padding: 15px;
            text-align: center;
        }
    </style>
</head>

<body>
    <form action="" method="post" enctype="multipart/form-data">
        <h1 id="previewContainer">Modifier le produit</h1>
        <input type="text" name="nom_produit" value="<?= htmlspecialchars($produit['nom_produit']) ?>" required>
        <input type="text" name="description" value="<?= htmlspecialchars($produit['description']) ?>" required>
        <input type="date" name="date" value="<?= htmlspecialchars($produit['date']) ?>" required>
        <p>Photo actuelle :</p>
        <img src="uploads/<?= htmlspecialchars($produit['photo']) ?>" width="100" id="previewContainer">
        <br><br>
        <label>Changer la photo :</label>
        <input type="file" name="photo" id="imageInput" accept="image/*">
        <br><br>
        <input type="submit" value="Mettre à jour">
    </form>
    <script src="../assets/js/produit.js"></script>
</body>

</html>