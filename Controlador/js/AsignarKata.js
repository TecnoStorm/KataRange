
var  formularioAsignar=document.getElementById("formularioAsignar")
var mensajeAsignar=document.getElementById("mensajeAsignar");
formularioAsignar.addEventListener('submit',function(e){
    e.preventDefault();
    EnvioAsignar();
})
function EnvioAsignar() {
    var datos = new FormData(formularioAsignar);
    var idKata = datos.get('idKata');
    var ciParticipante = datos.get('ciParticipante');
    var idTorneo = datos.get('idTorneo');
    var formData = new FormData();
    formData.append('idKata', idKata);
    formData.append('ciParticipante', ciParticipante);
    formData.append('idTorneo', idTorneo);
    fetch('../../Controlador/Kata/ControladorasignarKata.php', {
      method: 'POST',
      body: formData
    })
      .then(response => {
        if (!response.ok) {
          throw new Error('Hubo un problema con la solicitud');
        }
        return response.text(); 
      })
      .then(data => {
        mensajeAsignar.innerHTML = data;
      })
      .catch(error => {
        alert("Error en la solicitud");
      });
  }
  
  