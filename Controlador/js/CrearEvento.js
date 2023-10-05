var  CrearEvento=document.getElementById("CrearEvento")
var mensajeCrearEvento=document.getElementById("mensajeCrearEvento");
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
        mensajeCrearEvento.innerHTML = data;
      })
      .catch(error => {
        alert("Error en la solicitud");
      });
  }
  