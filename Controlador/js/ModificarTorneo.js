var modificarTorneo=document.getElementById("modificarTorneo")
var mensajeError=document.getElementById("mensajeErrorCedula")
var mensajeExito=document.getElementById("mensajeExito")

modificarTorneo.addEventListener('submit',function(e){
    e.preventDefault();
    EnvioModificar();
})
function EnvioModificar() {
    var datos = new FormData(modificarTorneo);
    var id = datos.get('id');
    var estado = datos.get('estado');  
    var formData = new FormData();
    formData.append('id', id);
    formData.append('estado', estado);
    fetch('../../Controlador/Torneo/EstadoTorneo.php', {
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

        if(data.includes("no existe el torneo")){
          var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
          myModal.show();
          mensajeError.innerHTML="El torneo seleccionado no existe"
        }

        if(data.includes("el torneo ya esta")){
          var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
          myModal.show();
          mensajeError.innerHTML="El torneo ya está "+estado;
        }

        if(data.includes("el torneo ahora esta:")){
          var myModal = new bootstrap.Modal(document.getElementById('modalExito'));
          myModal.show();
          mensajeExito.innerHTML="El torneo ahora está "+estado;
        }
      })
      .catch(error => {
        alert("Error en la solicitud");
      });
  }
  
  
  