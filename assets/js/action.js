// Fonction pour prévisualiser l'image sélectionnée
function previewImage(inputId, imgId) {
  const input = document.getElementById(inputId);
  const img = document.getElementById(imgId);

  input.addEventListener("change", function () {
    const file = this.files[0];
    if (file && file.type.startsWith("image/")) {
      const reader = new FileReader();
      reader.onload = function (e) {
        img.src = e.target.result;
      };
      reader.readAsDataURL(file);
    } else {
      img.src = "";
    }
  });
}

// Appliquer à chaque champ image
previewImage("image1", "visualiser1");
previewImage("image2", "visualiser2");
previewImage("image3", "visualiser3");
previewImage("image4", "visualiser4");
previewImage("image5", "visualiser5");
previewImage("image6", "visualiser6");
