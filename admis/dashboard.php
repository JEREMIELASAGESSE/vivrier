<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
htmlspecialchars($_SESSION['user'])
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/tableau.css">
    <title>Tableau de bord</title>
</head>

<body>
    <h1 class="font1">
        <strong>Bienvenue sur le tableau de bord !</strong>
    </h1>

    <ul style="border-top-left-radius: 30px;
  border-bottom-left-radius: 30px;
  border-top-right-radius: 5px;
  border-bottom-right-radius: 5px; background-color:#616161; display: inline-block; padding: 5px 10px; list-style: none;">
        <li><a href="../index.php" style="color:#F5F5F5; font-weight: 600;text-decoration: none; "><strong>RETOURNER SUR LE SITE</strong></a></li>
    </ul>
    <ul style="border-top-left-radius: 30px;
  border-bottom-left-radius: 30px;
  border-top-right-radius: 5px;
  border-bottom-right-radius: 5px; background-color:#616161; display: inline-block; padding: 5px 10px; list-style: none;">
        <li>
            <a href="logout.php" style="color:#F5F5F5; font-weight: 600;text-decoration: none; "><strong>Se Deconnecter</strong></a>
        </li>
    </ul>
    <div class="container">
        <div class="welcome-message">
            <p>Vous pouvez accéder aux différentes fonctionnalités</p>
        </div>
    </div>
    <p></p>
    <div class="containerst">
        <p><strong>Statistiques globales</strong></p>
        <table>
            <tr>
                <td>
                    <nav>
                        nombres d'équipes :
                    </nav>
                </td>
                <td>
                    <nav>
                        <strong>0</strong>
                    </nav>
                </td>
            </tr>
            <tr>
                <td>
                    <nav>
                        nombres d'actions :
                    </nav>
                </td>
                <td>
                    <nav>
                        <strong>0</strong>
                    </nav>
                </td>
            </tr>
            <tr>
                <td>
                    <nav>
                        nombres de partenaires :
                    </nav>
                </td>
                <td>
                    <nav>
                        <strong>0</strong>
                    </nav>
                </td>
            </tr>
        </table>


    </div>
    <div class="fonctionnalites-container">
        <div class="fonctionnalite">
            <img src="../assets/images/image/actiontb1.png" alt="Gestion des actions">
            <ul>
                <li><a href="tbaction.php">Gestion des actions</a></li>
            </ul>
        </div>
        <div class="fonctionnalite">
            <img src="../assets/images/image/actions.png" alt="Gestion des actions">
            <ul>
                <li><a href="tbpartenaire.php">Gestion des partenaires</a></li>
            </ul>
        </div>
        <div class="fonctionnalite">
            <img src="../assets/images/image/font1.jpg" alt="Gestion des actions">
            <ul>
                <li><a href="tbproduits.php">Gestion des produits</a></li>
            </ul>
        </div>
        <div class="fonctionnalite">
            <img src="../assets/images/image/equipes.png" alt="Gestion des actions">
            <ul>
                <li><a href="tbmembre.php">Gestion de l'équipe</a></li>
            </ul>
        </div>
        <div class="fonctionnalite">
            <img src="../assets/images/image/action4.jpg" alt="Gestion des actions">
            <ul>
                <li><a href="tbequipes.php">Gestion des utilisateurs</a></li>
            </ul>
        </div>
    </div>

</body>

</html>