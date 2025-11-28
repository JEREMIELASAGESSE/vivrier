<?php
require '../config/config.php';
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM actions WHERE id = ?");
$stmt->execute([$id]);
$action = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE actions SET nom_produit=?, description=?, beneficiere=?, date=? WHERE id=?");
    $stmt->execute([$_POST['nom_produit'], $_POST['description'], $_POST['beneficiere'], $_POST['date'], $id]);
    echo "<p style='color:green;'>✅ Action modifiée !</p>";
    header("Location: tbaction.php");
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>modifier action</title>
    <link rel="stylesheet" href="../assets/styles/tableau.css">
    <link rel="stylesheet" href="../assets/styles/index.css">
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

        @media (max-width: 768px) {
            h1 {
                text-align: center;
                color: var(--beige-creme);
                font-size: 1.2rem;
            }
        }
    </style>
    <form method="post">
        <input type="text" name="nom_produit" value="<?= $action['nom_produit'] ?>" required><br>
        <input type="text" name="description" value="<?= $action['description'] ?>" required><br>
        <input type="text" name="beneficiere" value="<?= $action['beneficiere'] ?>" required><br>
        <input type="date" name="date" value="<?= $action['date'] ?>" required><br>
        <div id="contient">
            <div id="champ">
                <input type="file" name="photo1" placeholder="L'image de l'action" id="image1" accept="image/*">
            </div>
            <div id="visualise">
                <img src="uploads/<?= htmlspecialchars($action['photo1']) ?>" alt="" id="visualiser1" required>
            </div>
        </div>
        <div id="contient">
            <div id="champ">
                <input type="file" name="photo2" id="image2" accept="image/*">
            </div>
            <div id="visualise">
                <img src="uploads/<?= htmlspecialchars($action['photo2']) ?>" alt="" id="visualiser2" required>
            </div>
        </div>
        <div id="contient">
            <div id="champ">
                <input type="file" name="photo3" id="image3" accept="image/*">
            </div>
            <div id="visualise">
                <img src="uploads/<?= htmlspecialchars($action['photo3']) ?>" alt="" id="visualiser3" required>
            </div>
        </div>
        <div id="contient">
            <div id="champ">
                <input type="file" name="photo4" id="image4" accept="image/*">
            </div>
            <div id="visualise">
                <img src="uploads/<?= htmlspecialchars($action['photo4']) ?>" alt="" id="visualiser4" required>
            </div>
        </div>
        <div id="contient">
            <div id="champ">
                <input type="file" name="photo5" id="image5" accept="image/*">
            </div>
            <div id="visualise">
                <img src="uploads/<?= htmlspecialchars($action['photo5']) ?>" alt="" id="visualiser5" required>
            </div>
        </div>
        <div id="contient">
            <div id="champ">
                <input type="file" name="photo6" id="image6" accept="image/*">
            </div>
            <div id="visualise">
                <img src="uploads/<?= htmlspecialchars($action['photo6']) ?>" alt="" id="visualiser6" required>
            </div>
        </div>
        <input type="submit" value="Mettre à jour">
    </form>
    <script src="../assets/js/action.js"></script>
    <script src="../assets/js/script.js"></script>

</body>

</html>