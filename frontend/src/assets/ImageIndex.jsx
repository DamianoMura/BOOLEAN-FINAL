const imageModules = import.meta.glob('./logos/*.{png,jpg,jpeg,svg}', { 
  eager: true 
});

// Crea un oggetto esportabile
const images = Object.fromEntries(
  Object.entries(imageModules).map(([path, module]) => [
    path.split('/').pop().split('.')[0], // Nome file senza estensione
    module.default
  ])
);

// Esporta tutte le immagini
export default images;