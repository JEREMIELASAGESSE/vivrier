<?php
include("../config/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom_produit'];
    $desc = $_POST['description'];
    $benef = $_POST['beneficiere'];
    $date = $_POST['date'];

    $photo1 = $_FILES['photo1'];
    $photo2 = $_FILES['photo2'];
    $photo3 = $_FILES['photo3'];
    $photo4 = $_FILES['photo4'];
    $photo5 = $_FILES['photo5'];
    $photo6 = $_FILES['photo6'];

    $photos = [];

    foreach ([$photo1, $photo2, $photo3, $photo4, $photo5, $photo6] as $index => $photo) {
        if ($photo['error'] === 0 && strpos($photo['type'], 'image/') === 0) {
            $filename = time() . "$index" . basename($photo['name']);
            $target = "uploads/" . $filename;
            move_uploaded_file($photo['tmp_name'], $target);
            $photos[] = $filename;
        } else {
            $photos[] = null;
        }
    }

    // Requête déplacée ici, après la boucle
    $stmt = $pdo->prepare("INSERT INTO actions (nom_produit, description, beneficiere, date, photo1, photo2, photo3, photo4, photo5, photo6)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $desc, $benef, $date, ...$photos]);

    echo "Action ajoutée avec succès !";
}

$actions = $pdo->query("SELECT * FROM actions")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/tableau.css">
    <link rel="stylesheet" href="../assets/styles/index.css">
    <!-- <link rel="stylesheet" href="../assets/styles/produit.css"> -->
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

            #e {
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
                width: 500px;
                padding: 15px;
                text-align: center;
            }

            .cart-produit a {
                display: block;
                margin: 0 10px;
                text-decoration: none;
                font-size: 18px;
            }

            #contient {
                display: flex;
                gap: 10px;
                margin-bottom: 10px;
            }

            #champ {
                flex: 3;
            }

            #visualise {
                flex: 1;
                display: flex;
                justify-content: center;
                align-items: center;
                border: 1px solid #ccc;
                border-radius: 5px;
                padding: 5px;
                max-height: 150px;
                margin-left: 10px;
            }

            #visualise img {
                max-width: 100%;
                max-height: 100px;
                border-radius: 10px;
            }

            #equipes {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                justify-content: center;
                margin-top: 30px;
            }

            /*code essai*/
        </style>
        <form action="" method="post" enctype="multipart/form-data">
            <h1 id="previewContainer">Ajouter une action </h1>
            <input type="text" name="nom_produit" placeholder="Intitulé de l'action" required>
            <input type="text" name="description" placeholder="Description de l'action" required>
            <input type="text" name="beneficiere" placeholder="Les bénéficieres " required>
            <input type="date" name="date" required>
            <div id="contient">
                <div id="champ">
                    <input type="file" name="photo1" placeholder="L'image de l'action" id="image1" accept="image/*" required>
                </div>
                <div id="visualise">
                    <img src="" alt="" id="visualiser1" required>
                </div>
            </div>
            <div id="contient">
                <div id="champ">
                    <input type="file" name="photo2" id="image2" accept="image/*" required>
                </div>
                <div id="visualise">
                    <img src="" alt="" id="visualiser2" required>
                </div>
            </div>
            <div id="contient">
                <div id="champ">
                    <input type="file" name="photo3" id="image3" accept="image/*" required>
                </div>
                <div id="visualise">
                    <img src="" alt="" id="visualiser3" required>
                </div>
            </div>
            <div id="contient">
                <div id="champ">
                    <input type="file" name="photo4" id="image4" accept="image/*" required>
                </div>
                <div id="visualise">
                    <img src="" alt="" id="visualiser4" required>
                </div>
            </div>
            <div id="contient">
                <div id="champ">
                    <input type="file" name="photo5" id="image5" accept="image/*" required>
                </div>
                <div id="visualise">
                    <img src="" alt="" id="visualiser5" required>
                </div>
            </div>
            <div id="contient">
                <div id="champ">
                    <input type="file" name="photo6" id="image6" accept="image/*" required>
                </div>
                <div id="visualise">
                    <img src="" alt="" id="visualiser6" required>
                </div>
            </div>

            <input type="submit" value="Ajouter une action">
        </form>
    </div>
    <!-- Affichage des actions -->
    <div id="equipes" class="slider-container">
        <?php foreach ($actions as $action): ?>
            <div class="cart-produit">
                <div class="slider-wrapper">
                    <button class="slider-btn left">&#10094;</button>
                    <div class="content-slider">
                        <img src="uploads/<?= htmlspecialchars($action['photo1']) ?>" alt="Produit 1" class="produit-image">
                        <img src="uploads/<?= htmlspecialchars($action['photo2']) ?>" alt="Produit 1" class="produit-image">
                        <img src="uploads/<?= htmlspecialchars($action['photo3']) ?>" alt="Produit 1" class="produit-image">
                        <img src="uploads/<?= htmlspecialchars($action['photo4']) ?>" alt="Produit 1" class="produit-image">
                        <img src="uploads/<?= htmlspecialchars($action['photo5']) ?>" alt="Produit 1" class="produit-image">
                        <img src="uploads/<?= htmlspecialchars($action['photo6']) ?>" alt="Produit 1" class="produit-image">
                    </div>
                    <button class="slider-btn right">&#10095;</button>
                </div>
                <div class="produit-details">
                    <h2><?= $action['nom_produit']; ?></h2>
                    <p>
                        <span class="localite"><strong><?= $action['beneficiere']; ?></strong></span><br>
                        <span class="description"><strong><?= $action['description']; ?></strong></span><br>
                        <span class="description"><strong><?= $action['date']; ?></strong></span><br>
                        <a href="modifier_action.php?id=<?= $action['id'] ?>">✏️ Modifier</a>
                        <a href="supprimer_action.php?id=<?= $action['id'] ?>" onclick="return confirm('Supprimer ?')">🗑️ Supprimer</a>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
    <?php include("../config/config.php"); ?>
    <script src="../assets/js/action.js"></script>
    <script src="../assets/js/script.js"></script>

</body>

</html>