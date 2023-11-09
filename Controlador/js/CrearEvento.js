var  CrearEvento=document.getElementById("CrearEvento")
var mensajeError=document.getElementById("mensajeErrorCedula")
var mensajeExito=document.getElementById("mensajeExito")

CrearEvento.addEventListener('submit',function(e){
    e.preventDefault();
    EnvioCrearEvento();
})
function EnvioCrearEvento() {
    var datos = new FormData(CrearEvento);
    var nombreEvento= datos.get('nombreEvento'); 
    var formData = new FormData();
    formData.append('nombreEvento', nombreEvento);  
    fetch('../../Controlador/Torneo/CrearEvento.php', {
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
        if(data.includes("el evento ya existe")){
          var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
          myModal.show();
          mensajeError.innerHTML="El nombre del evento ya está en uso"
        }
        else{
          var myModal = new bootstrap.Modal(document.getElementById('modalExito'));
          myModal.show();
          mensajeExito.innerHTML="Evento creado con éxito"
        }      })
      .catch(error => {
        alert("Error en la solicitud");
      });
  }
  