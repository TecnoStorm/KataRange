var  formularioMostrarPool=document.getElementById("formularioMostrarPool")
var mensajeMostrarPool=document.getElementById("mensajeMostrarPool");
formularioPool.addEventListener('submit',function(e){
    e.preventDefault();
    EnvioPool();
})
function EnvioPool() {
    var datos = new FormData(formularioMostrarPool);
    var id = datos.get('id'); 
    var estado = datos.get('estado'); 
    var formData = new FormData();
    formData.append('id', id);
    formData.append('estado', estado);  
    fetch('http://127.0.0.1/ProgramaPhp/PHP/Pool/OpcionesPool.php', {
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