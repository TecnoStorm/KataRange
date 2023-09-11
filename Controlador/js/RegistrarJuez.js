var formularioJuez=document.getElementById("formularioJuez")
var mensajeJuez=document.getElementById("mensajeJuez");
formularioJuez.addEventListener('submit',function(e){
    e.preventDefault();
    Envio();
})
function Envio() {
    var datos = new FormData(formularioJuez);
    var nombre = datos.get('nombre');
    var apellido = datos.get('apellido');
    var usuario = datos.get('usuario');
    var ci = datos.get('ci');
    var clave = datos.get('clave');
    var confirmacion = datos.get('confirmacion');   
    var formData = new FormData();
    formData.append('nombre', nombre);
    formData.append('apellido', apellido);
    formData.append('usuario', usuario);
    formData.append('ci', ci);
    formData.append('clave', clave);
    formData.append('confirmacion', confirmacion);
    fetch('../../Controlador/Juez/RegistrarJuez.php', {
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
        mensajeJuez.innerHTML = data;
      })
      .catch(error => {
        alert("Error en la solicitud");
      });
  }
  