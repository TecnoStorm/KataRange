var  formularioEscuela=document.getElementById("formularioEscuela")
var mensajeEscuela=document.getElementById("mensajeEscuela");
var mensajeModalError=document.getElementById("mensajeErrorCedula")
var mensajeModalExito=document.getElementById("mensajeExito")

formularioEscuela.addEventListener('submit',function(e){
    e.preventDefault();
    EnvioEscuela();
})
function EnvioEscuela() {
    var datos = new FormData(formularioEscuela);
    var nombre = datos.get('nombreEscuela'); 
    var tecnica = datos.get('tecnica'); 
    var formData = new FormData();
    formData.append('nombre', nombre);
    formData.append('tecnica', tecnica);  
    fetch('../../Controlador/Escuela/RegistrarEscuela.php', {
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
        if(data.includes("La escuela ya esta registrada")){
          var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
          myModal.show();
          mensajeModalError.innerHTML = "La escuela ya existe";
        }
        else{
          var myModal = new bootstrap.Modal(document.getElementById('modalExito'));
          myModal.show();
          mensajeModalExito.innerHTML = "La escuela se ha ingresado con éxito";
        }
      })
      .catch(error => {
        alert("Error en la solicitud");
      });
  }