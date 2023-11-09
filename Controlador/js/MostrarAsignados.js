var idTorneo = localStorage.getItem('idTorneo');
console.log(idTorneo + idTorneo)
var formData = new FormData();
formData.append("idTorneo", idTorneo); 
fetch('../../Controlador/Pool/MostrarPool.php', {
  method: "POST",
  body: formData,
  })

  .then(response => response.text())
  .then(data => {
    const resultado = document.getElementById('php');
    resultado.innerHTML = data;
    console.log("funco Bien"+ idTorneo)
  })
  .catch(error => {
    console.error('Error:', error);
  });