var formularioTorneo=document.getElementById("formularioTorneo")
var mensajeTorneo=document.getElementById("mensajeTorneo");
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
    var formData = new FormData();
    formData.append('fecha', fecha);
    formData.append('categoria', categoria);
    formData.append('paraKarate', paraKarate);
    formData.append('cantidad', cantidad);
    formData.append('sexo', sexo);
  
    fetch('http://127.0.0.1/ProgramaPhp/PHP/Torneo/CrearTorneo.php', {
      method: 'POST',
      body: formData
    })
      .then(response => {
        if (!response.ok) {
          throw new Error('Hubo un problema con la solicitud');
        }
        return response.text(); // Obtener la respuesta como texto
      })
      .then(data => {
        alert("funciono todo bien");
        mensajeTorneo.innerHTML = data;
      })
      .catch(error => {
        alert("Error en la solicitud");
      });
  }
  
  
  
  
  
  