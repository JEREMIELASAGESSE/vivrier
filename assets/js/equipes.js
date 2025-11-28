// Prévisualisation de l'image avant le téléchargement
const imageInput = document.getElementById("imageInput");
const previewContainer = document.getElementById("previewContainer");

imageInput.addEventListener("change", function () {
  const file = this.files[0];

  if (file && file.type.startsWith("image/")) {
    const reader = new FileReader();

    reader.onload = function (e) {
      previewContainer.innerHTML = `<img src="${e.target.result}" alt="Image sélectionnée">`;
    };

    reader.readAsDataURL(file);
  } else {
    previewContainer.innerHTML = `<span>Fichier non valide</span>`;
  }
});
// Validation du formulaire d'équipe
document.querySelector("form").addEventListener("submit", function (e) {
  const nom = document.querySelector('input[name="nom_U"]').value.trim();
  const prenom = document.querySelector('input[name="prenom_U"]').value.trim();
  const user = document.querySelector('input[name="user"]').value.trim();
  const password = document.querySelector('input[name="password"]').value;
  const contact = document
    .querySelector('input[name="contact_U"]')
    .value.trim();
  const adresse = document
    .querySelector('input[name="Adresse_U"]')
    .value.trim();
  const date = document.querySelector('input[name="date"]').value;
  const photo = document.querySelector('input[name="photo"]').files[0];

  // Vérification des champs vides
  if (
    !nom ||
    !prenom ||
    !user ||
    !password ||
    !contact ||
    !adresse ||
    !date ||
    !photo
  ) {
    alert("Tous les champs doivent être remplis.");
    e.preventDefault();
    return;
  }

  // Vérification du mot de passe
  if (password.length < 6) {
    alert("Le mot de passe doit contenir au moins 6 caractères.");
    e.preventDefault();
    return;
  }

  // Vérification du format du contact (ex: numéro de téléphone)
  const contactRegex = /^[0-9]{8,15}$/;
  if (!contactRegex.test(contact)) {
    alert("Le contact doit être un numéro valide (8 à 15 chiffres).");
    e.preventDefault();
    return;
  }

  // Vérification du type de fichier image
  const allowedTypes = ["image/jpeg", "image/png", "image/jpg"];
  if (!allowedTypes.includes(photo.type)) {
    alert("Le fichier doit être une image (jpg, jpeg, png).");
    e.preventDefault();
    return;
  }
});
