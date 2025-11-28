<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/styles/index.css">
  <title>Contactez DIGITAL KPADJALE</title>
</head>

<body>
  <?php include('menu.php'); ?>
  <div class="home-page__background_contact">
    <h1 class="titre"><strong>Contactez-nous</strong></h1>
    <!-- <img src="" alt="Image de fond" class="home-page__image" class="produit-image"> -->
  </div>
  <div class="contact">
    <section class="partie1">
      <div class="email_telephone_whatssap">
        <p>
          <strong><img src="assets/images/icon/mail.png" alt="ddd" class="logo" />:</strong>
          <a href="mailto:ndrikouamejeremie@mail.com"> Email</a>
        </p>
        <p>
          <strong><img src="assets/images/icon/phone.png" alt="ddd" class="logo" />:</strong>
          <a href="tel:+2250769373509">0769373509</a>
        </p>
        <p>
          <strong><img src="assets/images/icon/whatsapp.png" alt="ddd" class="logo" /> :</strong>
          <a
            href="https://wa.me/2250500429932?text=Bonjour%20KOUAME,%20je%20viens%20du%20site%20et%20j’ai%20une%20question
">
            WhatsApp</a>
        </p>
        <p>
          <strong><img src="assets/images/icon/facebook.png" alt="ddd" class="logo" /> :</strong>
          <a href="https://www.facebook.com/coopaahs">Facebook</a>
        </p>
        <div class="text">
          <p>
            Nous serons ravis de vous entendre et de répondre à vos questions. N'hésitez pas à nous
            contacter pour toute information ou assistance. Notre équipe est là pour vous aider.
          </p>

        </div>
      </div>
      <div class="map">
        <iframe
          src="https://www.google.com/maps?q=VHG7+RGQ,+Daloa,+Côte+d’Ivoire&output=embed"
          width="600"
          height="450"
          style="border: 0"
          allowfullscreen=""
          loading="lazy"></iframe>
      </div>
    </section>
    <h1>Formulaire de contact</h1>
    <section id="contact">
      <div class="form">
        <form action="">
          <input type="text" placeholder="votre nom " required />
          <input type="email" placeholder="votre e-mail " required />
          <input type="text" placeholder="l'objet " required />
          <textarea
            name=""
            id=""
            cols="30"
            rows="10"
            placeholder="votre message"
            required></textarea>
          <button type="submit" class="infobtn">Envoyer</button>
        </form>
      </div>
      <div class="membre">
        <h1>Nos responsables et patenaires</h1>
        <div class="perso">
          <img src="assets/images/logo/logo_orange.jpg" alt="ddd" class="logo" />
          <ul>
            <li>
              <b> DIGITAL KPADJALE</b>
            </li>
            <li>tel:+2250705694004</li>
          </ul>
        </div>
        <div class="perso">
          <img src="assets/images/image/dady1 (1).jpg" alt="ddd" class="logo" />
          <ul>
            <li>
              <b>N'dri Jeremie</b>
            </li>
            <li>tel:+2250500429932</li>
          </ul>
        </div>
        <div class="perso">
          <img src="assets/images/image/hypiness.jpg" alt="ddd" class="logo" />
          <ul>
            <li>
              <b>Dorcas kouame</b>
            </li>
            <li>tel:+2250769373509</li>
          </ul>
        </div>
        <div class="perso">
          <img src="assets/images/image/happyness1.jpg" alt="ddd" class="logo" />
          <ul>
            <li>
              <b>Konan Dorcas</b>
            </li>
            <li>tel:+2250556036685</li>
          </ul>
        </div>
      </div>
    </section>
  </div>
  <?php include 'footer.php'; ?>
</body>

</html>