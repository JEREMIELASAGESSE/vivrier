<?php
include("../config/config.php");

// Ajouter un produit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom_produit'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    // Gestion de l'image
    $photo = $_FILES['photo']['name'];
    $target = 'uploads/' . basename($photo);
    move_uploaded_file($_FILES['photo']['tmp_name'], $target);

    $stmt = $pdo->prepare("INSERT INTO produits (nom_produit, description, date, photo) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nom, $description, $date, $photo]);
}

// Supprimer un produit
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM produits WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: tbproduits.php");
    exit;
}
// Récupérer les produits
$produits = $pdo->query("SELECT * FROM produits")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/tableau.css">
    <link rel="stylesheet" href="../assets/styles/produit.css">
    <title>GESTION DES PRODUITS</title>
</head>

<body>
    <h1 class="font1">
        <strong>GESTION COMPLETE DES PRODUITS</strong>
    </h1>
    <ul style="border-top-left-radius: 30px;
  border-bottom-left-radius: 30px;
  border-top-right-radius: 5px;
  border-bottom-right-radius: 5px; background-color:#D32F2F; display: inline-block; padding: 5px 10px; list-style: none;">
        <li><a href="dashboard.php" style="color:#9E9E9E; font-weight: 600;text-decoration: none; "><strong>RETOUR</strong></a></li>
    </ul>
    <div id="formulaire_ajoute">
        <!--formulaire et tableau de gestion des produits ici-->
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
        <form action="" method="post" enctype="multipart/form-data">
            <h1 id="previewContainer">Ajouter un produit </h1>
            <input type="text" name="nom_produit" placeholder="Nom du produit" required>
            <input type="text" name="description" placeholder="Description du produit" required>
            <input type="date" name="date" required>
            <input type="file" name="photo" placeholder="L'image du produit" id="imageInput" required>
            <input type="submit" value="Ajouter le produit" accept="image/*" required>
        </form>
    </div>
    <!-- Affichage des produits -->
    <div id="affiche_produit">
        <?php foreach ($produits as $produit): ?>
            <div class="cart-produit">
                <img src="uploads/<?= htmlspecialchars($produit['photo']) ?>" alt="<?= htmlspecialchars($produit['nom_produit']) ?>" class="produit-image">
                <div class="produit-details">
                    <h2><?= htmlspecialchars($produit['nom_produit']) ?></h2>
                    <p><?= htmlspecialchars($produit['description']) ?></p>
                    <h3><?= htmlspecialchars($produit['date']) ?></h3>
                    <h4><a href="tbmodifieproduits.php?id=<?= $produit['id'] ?>">Modifier</a></h4>
                    <h4><a href="?delete=<?= $produit['id'] ?>" onclick="return confirm('Supprimer ce produit ?')">Supprimer</a></h4>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php include("../config/config.php"); ?>
    <script src="../assets/js/produit.js"></script>
</body>

</html>