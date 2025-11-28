<?php
require("../config/config.php");
$errors = [];
$nom = $prenom = $contact = $adresse = $date = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom_U']);
    $prenom = trim($_POST['prenom_U']);
    $contact = trim($_POST['contact_U']);
    $adresse = trim($_POST['Adresse_U']);
    $date = $_POST['date'];

    // Vérifications
    if (!$nom || !$prenom || !$contact || !$adresse || !$date) {
        $errors[] = "Tous les champs doivent être remplis.";
    }

    if (!preg_match('/^\d{10}$/', $contact)) {
        $errors[] = "Le contact doit contenir 10 chiffres.";
    }

    if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK || !str_starts_with($_FILES['photo']['type'], 'image/')) {
        $errors[] = "Le fichier doit être une image valide.";
    }

    // Si pas d'erreurs, on insère
    if (empty($errors)) {
        $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $photo = uniqid('user_') . '.' . $extension;
        $target = 'uploads/' . $photo;
        move_uploaded_file($_FILES['photo']['tmp_name'], $target);

        $stmt = $pdo->prepare("INSERT INTO partenaire (nom_U, prenom_U, contact_U, Adresse_U, date, photo) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $prenom, $contact, $adresse, $date, $photo]);

        header("Location: tbpartenaire.php");
        exit;
    }
}
$utilisateurs = $pdo->query("SELECT * FROM partenaire ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/tableau.css">
    <link rel="stylesheet" href="../assets/styles/produit.css">
    <title>GESTION DE L'EQUIPE</title>
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
            max-height: 50px;
        }
    </style>
</head>

<body>
    <h1 class="font1">
        <strong>GESTION COMPLETE DES MEMBRES</strong>
    </h1>
    <ul style="border-top-left-radius: 30px;
  border-bottom-left-radius: 30px;
  border-top-right-radius: 5px;
  border-bottom-right-radius: 5px; background-color:#D32F2F; display: inline-block; padding: 5px 10px; list-style: none;">
        <li><a href="dashboard.php" style="color:#9E9E9E; font-weight: 600;text-decoration: none; "><strong>RETOUR</strong></a></li>
    </ul>
    <div id="formulaire_ajoute">
        <!--formulaire et tableau de gestion des produits ici-->

        <form action="" method="post" enctype="multipart/form-data">
            <h1 id="previewContainer">Ajouter un utilisateur </h1>
            <?php if (!empty($errors)): ?>
                <div class="error-box">
                    <ul>
                        <?php foreach ($errors as $err): ?>
                            <li><?= htmlspecialchars($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <input type="text" name="nom_U" placeholder="Le Nom" required>
            <input type="text" name="prenom_U" placeholder="Le Prenom" required>
            <input type="text" name="contact_U" placeholder="Contact" required>
            <input type="text" name="Adresse_U" placeholder="Adresse" required>
            <input type="date" name="date" required>
            <input type="file" name="photo" id="imageInput" required>
            <input type="submit" value="Ajouter le produit" accept="image/*">
        </form>
    </div>
    <div id="affiche_prod>
        <section class=" propos-page">
        <table border="1">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Contact</th>
                    <th>Adresse</th>
                    <th>Date</th>
                    <th>Photo</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($utilisateurs as $u): ?>
                    <tr>
                        <td><?= htmlspecialchars($u['nom_U']) ?></td>
                        <td><?= htmlspecialchars($u['prenom_U']) ?></td>
                        <td><?= htmlspecialchars($u['contact_U']) ?></td>
                        <td><?= htmlspecialchars($u['Adresse_U']) ?></td>
                        <td><?= htmlspecialchars($u['date']) ?></td>
                        <td>
                            <?php if (!empty($u['photo'])): ?>
                                <img src="uploads/<?= htmlspecialchars($u['photo']) ?>" alt="Photo">
                            <?php else: ?>
                                <span>Aucune image</span>
                            <?php endif; ?>
                        </td>
                        <td><a class="btn modifier" href="tbmodifiepartenaire.php?id=<?= $u['id'] ?>">Modifier</a></td>
                        <td><a class="btn supprimer" href="supprimepartenaire.php?id=<?= $u['id'] ?>" onclick="return confirm('Confirmer la suppression ?')">Supprimer</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        </section>
    </div>
    <script src="../assets/js/equipes.js"></script>
    <script src="../assets/js/tbmembre.js"></script>
</body>

</html>