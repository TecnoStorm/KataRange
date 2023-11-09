console.log("prueba2");
var  formularioGuardarPool=document.getElementById("formularioGuardarPool")
var mensajePoolsTorneos=document.getElementById("mensajePoolsTorneos");
formularioGuardarPool.addEventListener('submit',function(e){
    e.preventDefault();
    EnvioPoolTorneo();
})

function EnvioPoolTorneo() {
    var datos = new FormData(formularioGuardarPool);
    var nombreTorneo = datos.get('nombreTorneo');
    var formData = new FormData();
    formData.append('nombreTorneo', nombreTorneo);
    fetch('../../Controlador/Pool/PoolTorneo.php', {
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
        mensajePoolsTorneos.innerHTML = data;
      })
      .catch(error => {
        alert("Error en la solicitud");
      });
  }
  