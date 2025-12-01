<?php
include("config/config.php");
$produits = $pdo->query("SELECT * FROM produits")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/styles/index.css">
  <title>Nos produits</title>
</head>

<body>
  <?php include('menu.php'); ?>
  <div class="home-page__background_produit">
    <h1 class="titre"><strong>NOUS AVONS DES PRODUITS DE QUALITES</strong></h1>
    <!-- <img src="" alt="Image de fond" class="home-page__image" class="produit-image"> -->
  </div>
  <section class="propos-page">
    <?php foreach ($produits as $produit): ?>
      <div class="equipes">
        <div class="cart-produit">
          <img src="admis/uploads/<?= htmlspecialchars($produit['photo']) ?>" alt="<?= htmlspecialchars($produit['nom_produit']) ?>" class="produit-image">
          <div class="produit-details">
            <h2><?= htmlspecialchars($produit['nom_produit']) ?></h2>
            <p><?= htmlspecialchars($produit['description']) ?></p>
            <h3><?= htmlspecialchars($produit['date']) ?></h3>
            <h4><a href="tel:+255O500429932" class="home-page2__link">Interessé</a></h4>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </section>
  <?php include 'footer.php'; ?>
</body>

</html>