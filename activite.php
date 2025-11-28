<?php
require 'config/config.php';
$actions = $pdo->query("SELECT * FROM actions ORDER BY id DESC");


?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/styles/index.css">
  <title>Nos Actions</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      padding: 20px;
    }

    #equipes {
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
      width: 800px;
      padding: 15px;
      text-align: center;
      max-height: 70vh;
      overflow: hidden;
    }

    @media (max-width: 768px) {
      .cart-produit {
        width: 100%;
      }
    }
  </style>
</head>

<body>
  <?php include('menu.php'); ?>
  <div class="home-page__background_activite">
    <h1><strong>NOS PRODUCTEURS AU COEUR DE NOS ACTIONS</strong></h1>

  </div>
  <section class="propos-page">
    <!-- Affichage des actions -->
    <div id="equipes">
      <?php foreach ($actions as $action): ?>
        <div class="cart-produit" class="slider-container">
          <div class="slider-wrapper">
            <button class="slider-btn left">&#10094;</button>
            <div class="content-slider">
              <img src="admis/uploads/<?= htmlspecialchars($action['photo1']) ?>" alt="Produit 1" class="produit-image">
              <img src="admis/uploads/<?= htmlspecialchars($action['photo2']) ?>" alt="Produit 1" class="produit-image">
              <img src="admis/uploads/<?= htmlspecialchars($action['photo3']) ?>" alt="Produit 1" class="produit-image">
              <img src="admis/uploads/<?= htmlspecialchars($action['photo4']) ?>" alt="Produit 1" class="produit-image">
              <img src="admis/uploads/<?= htmlspecialchars($action['photo5']) ?>" alt="Produit 1" class="produit-image">
              <img src="admis/uploads/<?= htmlspecialchars($action['photo6']) ?>" alt="Produit 1" class="produit-image">
            </div>
            <button class="slider-btn right">&#10095;</button>
          </div>
          <div class="produit-details">
            <h2><?= $action['nom_produit']; ?></h2>
            <p>
              <span class="localite"><strong><?= $action['beneficiere']; ?></strong></span><br>
              <span class="description"><strong><?= $action['description']; ?></strong></span><br>
            </p>
          </div>
        </div>
      <?php endforeach; ?>

  </section>
  <script src="assets/js/script.js"></script>
  <?php include 'footer.php'; ?>
</body>

</html>