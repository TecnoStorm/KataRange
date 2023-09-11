var  formularioCrear=document.getElementById("formularioCrear")
var mensajeCrear=document.getElementById("mensajeCrear");
formularioCrear.addEventListener('submit',function(e){
    e.preventDefault();
    EnvioCrear();
})
function EnvioCrear() {
    var datos = new FormData(formularioCrear);
    var nombreTorneo = datos.get('nombreTorneo'); 
    var formData = new FormData();
    formData.append('nombreTorneo', nombreTorneo);
    fetch('../../Controlador/Pool/CrearPool.php', {
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
        mensajeCrear.innerHTML = data;
      })
      .catch(error => {
        alert("Error en la solicitud");
      });
  }
  