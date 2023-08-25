var  asignarTorneo=document.getElementById("asignarTorneo")
var mensajeAsignarTorneo=document.getElementById("mensajeAsignarTorneo");
asignarTorneo.addEventListener('submit',function(e){
    e.preventDefault();
    EnvioAsignar();
})
function EnvioAsignar() {
    var datos = new FormData(asignarTorneo);
    var id = datos.get('id'); 
    var formData = new FormData();
    formData.append('id', id);  
    fetch('http://127.0.0.1/ProgramaPhp/PHP/Torneo/AsignarParticipantes.php', {
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
        alert("funciono todo bien");
        mensajeAsignarTorneo.innerHTML = data;
      })
      .catch(error => {
        alert("Error en la solicitud");
      });
  }
  