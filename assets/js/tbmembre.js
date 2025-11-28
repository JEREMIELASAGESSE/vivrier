document.querySelector("form").addEventListener("submit", function (e) {
  const nom = document.querySelector('input[name="nom_U"]').value.trim();
  const prenom = document.querySelector('input[name="prenom_U"]').value.trim();
  const post = document.querySelector('input[name="post"]').value.trim();
  const salaire = document.querySelector('input[name="salaire"]').value.trim();
  const contact = document
    .querySelector('input[name="contact_U"]')
    .value.trim();
  const adresse = document
    .querySelector('input[name="Adresse_U"]')
    .value.trim();
  const date = document.querySelector('input[name="date"]').value;
  const photo = document.querySelector('input[name="photo"]').files[0];

  let errors = [];

  if (
    !nom ||
    !prenom ||
    !post ||
    !salaire ||
    !contact ||
    !adresse ||
    !date ||
    !photo
  ) {
    errors.push("Tous les champs doivent être remplis.");
  }

  if (isNaN(salaire)) {
    errors.push("Le salaire doit être un nombre.");
  }

  if (!/^\d{10}$/.test(contact)) {
    errors.push("Le contact doit contenir 10 chiffres.");
  }

  if (photo && !photo.type.startsWith("image/")) {
    errors.push("Le fichier doit être une image.");
  }

  if (errors.length > 0) {
    e.preventDefault();
    alert(errors.join("\n"));
  }
});
