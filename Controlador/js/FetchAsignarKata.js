function cargarScripts() {
  const script1 = document.createElement('script');
  script1.src = '../../Controlador/js/AsignarKata.js';
  document.body.appendChild(script1);

}
var nombreTorneo = localStorage.getItem('nombreTorneo');
var formData = new FormData();
formData.append("nombreTorneo", nombreTorneo); 
fetch('../../Controlador/Tecnico/AsignarKata.php', {
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