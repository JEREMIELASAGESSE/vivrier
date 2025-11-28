//visualisation de l'image sélectionnée
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
// Validation du formulaire de produit
document.querySelector("form").addEventListener("submit", function (e) {
  const nomProduit = document
    .querySelector('input[name="nom_produit"]')
    .value.trim();
  const description = document
    .querySelector('input[name="description"]')
    .value.trim();
  const date = document.querySelector('input[name="date"]').value;
  const photoInput = document.querySelector('input[name="photo"]');
  const photo = photoInput.files[0];

  // Vérification du nom et de la description
  const regexText = /^[a-zA-Z0-9À-ÿ\s\-_,\.;:()]+$/;
  if (!regexText.test(nomProduit) || !regexText.test(description)) {
    alert("Le nom ou la description contient des caractères non autorisés.");
    e.preventDefault();
    return;
  }

  // Vérification de la date
  if (new Date(date) > new Date()) {
    alert("La date ne peut pas être dans le futur.");
    e.preventDefault();
    return;
  }

  // Vérification du fichier image
  if (!photo) {
    alert("Veuillez sélectionner une image.");
    e.preventDefault();
    return;
  }

  const allowedTypes = ["image/jpeg", "image/png", "image/gif", "image/jpg"];
  if (!allowedTypes.includes(photo.type)) {
    alert("Seuls les fichiers JPEG, PNG,JPG ou GIF sont autorisés.");
    e.preventDefault();
    return;
  }

  const maxSize = 2 * 1024 * 1024; // 2MB
  if (photo.size > maxSize) {
    alert("La taille de l'image ne doit pas dépasser 2MB.");
    e.preventDefault();
    return;
  }
});
