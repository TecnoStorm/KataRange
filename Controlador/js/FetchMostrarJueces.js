function cargarScripts() {
    const script1 = document.createElement('script');
    script1.src = '../../Controlador/js/traduccion.js';
    document.body.appendChild(script1);
}

fetch('../../Controlador/Juez/MostrarJueces.php')
  .then(response => response.text())
  .then(data => {
    const resultado = document.getElementById('php');
    resultado.innerHTML = data;
    cargarScripts();
  })
  .catch(error => {
    console.error('Error:', error);
  });
