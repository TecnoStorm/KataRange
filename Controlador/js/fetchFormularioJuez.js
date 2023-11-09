function cargarScripts() {
    const script1 = document.createElement('script');
    script1.src = '../../Controlador/js/RegistrarJuez.js';
    document.body.appendChild(script1);
  
    const script2 = document.createElement('script');
    script2.src = '../../Controlador/js/traduccion.js';
    document.body.appendChild(script2);
}

fetch('../../Controlador/Juez/RegistrarJuezVista.php')
  .then(response => response.text())
  .then(data => {
    const resultado = document.getElementById('php');
    resultado.innerHTML = data;
    cargarScripts()
  })
  .catch(error => {
    console.error('Error:', error);
  });