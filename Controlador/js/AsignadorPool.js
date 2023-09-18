var  formularioPool=document.getElementById("formularioPool")
var mensaje=document.getElementById("mensaje");
formularioPool.addEventListener('submit',function(e){
    e.preventDefault();
    Envio();
})
function Envio() {
    var datos = new FormData(formularioPool);
    datos.forEach(function(value, key) {
      console.log(key + ": " + value);
    });
    var id = datos.get('id'); 
    var estado = datos.get('estado');
    alert (id);
    alert (estado);
    var formData = new FormData();
    formData.append('id', id);
    formData.append('estado', estado);  
    fetch('../../Controlador/Pool/OpcionesPool.php', {
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
  