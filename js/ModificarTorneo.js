var modificarTorneo=document.getElementById("modificarTorneo")
var mensajeEditarTorneo=document.getElementById("mensajeEditarTorneo");
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
    fetch('http://127.0.0.1/ProgramaPhp/PHP/Torneo/EstadoTorneo.php', {
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
        mensajeTorneo.innerHTML = data;
      })
      .catch(error => {
        alert("Error en la solicitud");
      });
  }
  
  
  