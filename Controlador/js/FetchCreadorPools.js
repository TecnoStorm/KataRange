function cargarScripts() {
    const script1 = document.createElement('script');
    script1.src = '../../Controlador/js/CreadorPool.js';
    document.body.appendChild(script1);
  
    const script2 = document.createElement('script');
    script2.src = '../../Controlador/js/traduccion.js';
    document.body.appendChild(script2);
    
    const script3 = document.createElement('script');
    script3.src = '../../Controlador/js/AsignadorPool.js';
    document.body.appendChild(script3);

    const script4 = document.createElement('script');
    script4.src = '../../Controlador/js/EnvioMostrarAsignados.js';
    document.body.appendChild(script4);
}
var nombreTorneo = localStorage.getItem('nombreTorneo');
var formData = new FormData();
formData.append("nombreTorneo", nombreTorneo);
fetch('../../Controlador/Pool/CreadorPools.php', {
  method: "POST",
  body: formData,
  })

  .then(response => response.text())
  .then(data => {
    const resultado = document.getElementById('php');
    resultado.innerHTML = data;
    cargarScripts()
  })
  .catch(error => {
    console.error('Error:', error);
  });