var formulario=document.getElementById("registrarParticipante")
var mensaje=document.getElementById("mensaje");
registrarParticipante.addEventListener('submit',function(e){
    e.preventDefault();
    EnvioRegistrarParticipante();
})
function  EnvioRegistrarParticipante() {
    var datos = new FormData(formulario);
    var ci = datos.get('ci');
    var nombre = datos.get('nombre');
    var apellido = datos.get('apellido');
    var categoria = datos.get('categoria');
    var sexo = datos.get('sexo');
    var condicion = datos.get('Condicion');
    var idkata = datos.get('idKata');
    var nombreTorneo = datos.get('nombreTorneo');
    var tecnica = datos.get('tecnica');
    var nombreEscuela = datos.get('nombreEscuela');   
    var formData = new FormData();
    formData.append('ci', ci);
    formData.append('nombre', nombre);
    formData.append('apellido', apellido);
    formData.append('categoria', categoria);
    formData.append('sexo', sexo);
    formData.append('Condicion', condicion);
    formData.append('idKata', idkata);
    formData.append('nombreTorneo', nombreTorneo);
    formData.append('tecnica', tecnica);
    formData.append('nombreEscuela', nombreEscuela);

  
    fetch('../../Controlador/Participante/Registrar.php', {
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
        mensaje.innerHTML = data;
      })
      .catch(error => {
        alert("Error en la solicitud");
      });
  }
  
  
  
  
  
  