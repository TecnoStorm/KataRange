var  formularioEscuela=document.getElementById("formularioEscuela")
var mensajeEscuela=document.getElementById("mensajeEscuela");
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
    fetch('http://127.0.0.1/ProgramaPhp/PHP/Escuela/RegistrarEscuela.php', {
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
        mensajeEscuela.innerHTML = data;
      })
      .catch(error => {
        alert("Error en la solicitud");
      });
  }