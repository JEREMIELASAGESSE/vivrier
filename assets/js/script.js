document.addEventListener("DOMContentLoaded", () => {
  // 1. Sélectionner tous les conteneurs de slider sur la page
  const sliders = document.querySelectorAll(".slider-wrapper");

  // 2. Initialiser chaque slider individuellement
  sliders.forEach((sliderWrapper) => {
    // Variables locales à ce slider spécifique
    const contentSlider = sliderWrapper.querySelector(".content-slider");
    const images = sliderWrapper.querySelectorAll(".produit-image");
    const prevBtn = sliderWrapper.querySelector(".slider-btn.left");
    const nextBtn = sliderWrapper.querySelector(".slider-btn.right");

    let currentIndex = 0;
    const totalImages = images.length;

    // Fonction pour mettre à jour la position du slider (locale)
    function updateSliderPosition() {
      // Calcule le décalage basé sur l'index actuel
      // Chaque image prend 100% de la largeur du content-slider
      const offset = -currentIndex * 100;
      contentSlider.style.transform = `translateX(${offset}%)`;
    }

    // Configuration CSS nécessaire pour l'animation (à ajouter à votre feuille de style)
    /*
        .content-slider {
            display: flex;
            transition: transform 0.3s ease-in-out; 
            width: 100%; // Important pour que les images s'alignent
        }
        .slider-wrapper {
            overflow: hidden; // Cache les images qui débordent
            position: relative;
        }
        .produit-image {
            min-width: 100%; // Chaque image prend 100% de la largeur disponible
            height: auto; // ou une hauteur fixe
        }
        */

    // Gestion du bouton SUIVANT
    nextBtn.addEventListener("click", () => {
      if (currentIndex < totalImages - 1) {
        currentIndex++;
      } else {
        // Option : Revenir au début (boucle)
        currentIndex = 0;
      }
      updateSliderPosition();
    });

    // Gestion du bouton PRÉCÉDENT
    prevBtn.addEventListener("click", () => {
      if (currentIndex > 0) {
        currentIndex--;
      } else {
        // Option : Aller à la fin (boucle)
        currentIndex = totalImages - 1;
      }
      updateSliderPosition();
    });

    // Afficher uniquement la première image au chargement
    updateSliderPosition();
  });
});
