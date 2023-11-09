console.log("adios");
var formularioTorneo=document.getElementById("formularioTorneo")
var mensajeError=document.getElementById("mensajeErrorCedula")
var mensajeExito=document.getElementById("mensajeExito")

formularioTorneo.addEventListener('submit',function(e){
    e.preventDefault();
    EnvioCrear();
})

function EnvioCrear() {
    var datos = new FormData(formularioTorneo);
    var fecha = datos.get('fecha');
    var categoria = datos.get('categoria');
    var paraKarate = datos.get('paraKarate');
    var cantidad = datos.get('cantidad');
    var sexo = datos.get('sexo');  
    var nombre=datos.get('nombre');
    var direccion=datos.get('direccion');
    var nombreEvento=datos.get('nombreEvento');
    var formData = new FormData();
    formData.append('fecha', fecha);
    formData.append('categoria', categoria);
    formData.append('paraKarate', paraKarate);
    formData.append('cantidad', cantidad);
    formData.append('sexo', sexo);
    formData.append('nombre',nombre);
    formData.append('direccion',direccion);
    formData.append('nombreEvento',nombreEvento);
    fetch('../../Controlador/Torneo/CrearTorneo.php', {
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
        if(data.includes("nombre en uso")){
          var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
          myModal.show();
          mensajeError.innerHTML="El nombre de torneo ya está en uso"
        }
        else{
          var myModal = new bootstrap.Modal(document.getElementById('modalExito'));
          myModal.show();
          mensajeExito.innerHTML="Torneo creado con éxito"
        }

      })
      .catch(error => {
        alert("Error en la solicitud");
      });
  }
  
  
  
  
  
  