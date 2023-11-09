function cargarScripts() {
  const script1 = document.createElement('script');
  script1.src = '../../Controlador/js/EnviarPool.js';
  document.body.appendChild(script1);

  const script2 = document.createElement('script');
  script2.src = '../../Controlador/js/EnvioKata.js';
  document.body.appendChild(script2);

  const script3 = document.createElement('script');
  script3.src = '../../Controlador/js/EnvioElegirParticipante.js';
  document.body.appendChild(script3);
}
fetch('../../Controlador/Tecnico/Tecnico.php')
  .then(response => response.text())
  .then(data => {
    const resultadoTecnico = document.getElementById('resultadoTecnico');
    resultadoTecnico.innerHTML = data;
    cargarScripts()
  })
  .catch(error => {
    console.error('Error:', error);
  });