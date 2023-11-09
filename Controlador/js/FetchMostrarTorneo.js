
fetch('../../Controlador/Torneo/MostrarTorneo.php')
  .then(response => response.text())
  .then(data => {
    const resultado = document.getElementById('php');
    resultado.innerHTML = data;
  })
  .catch(error => {
    console.error('Error:', error);
  });
