var  formularioCrear=document.getElementById("formularioCrear")
var mensajeError=document.getElementById("mensajeErrorCedula")
var mensajeExito=document.getElementById("mensajeExito")
var botonCerrar=document.getElementById("botonCerrar")
var xCerrar=document.querySelector(".botonCerrar")

botonCerrar.addEventListener('click', function(e){
  e.preventDefault;
  location.reload();
})

xCerrar.addEventListener('click', function(e){
  e.preventDefault;
  location.reload();
})

formularioCrear.addEventListener('submit',function(e){
    e.preventDefault();
    EnvioCrear();
})
function EnvioCrear() {
    var datos = new FormData(formularioCrear);
    var idTorneo = datos.get('idTorneo');
    var formData = new FormData();
    formData.append('idTorneo', idTorneo);
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
        if(data.includes("pools creados correctamente")){
          var myModal = new bootstrap.Modal(document.getElementById('modalExito'));
          myModal.show();
          mensajeExito.innerHTML="Pools creados correctamente"
        }
        mensajeCrear.innerHTML = data;
      })
      .catch(error => {
        alert("Error en la solicitud");
      });
  }
  