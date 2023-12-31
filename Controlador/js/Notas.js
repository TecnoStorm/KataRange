var  formularioNotas=document.getElementById("formularioNotas")
var mensajeNotas=document.getElementById("mensajeNotas");
formularioNotas.addEventListener('submit',function(e){
    e.preventDefault();
    EnvioNotas();
})
function EnvioNotas() {
    var datos = new FormData(formularioNotas);
    var nota = datos.get('nota'); 
    var formData = new FormData();
    formData.append('nota', nota);  
    fetch('../../Controlador/Puntaje.php', {
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
        mensajeNotas.innerHTML = data;
      })
      .catch(error => {
        alert("Error en la solicitud");
      });
  }
  