var  formularioPool=document.getElementById("formularioPool")
var mensajeError=document.getElementById("mensajeErrorCedula");
var mensajeExito=document.getElementById("mensajeExito");
var botonCerrar=document.getElementById("botonCerrar")
var xCerrar=document.querySelector(".botonCerrar")

botonCerrar.addEventListener('click', function(e){
  e.preventDefault;
  location.reload();
})

xCerrar.addEventListener('click', function(e){
  e.preventDefault;
  location.reload();
})


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
        if(data.includes("El pool ya esta")){
          var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
          myModal.show();
          mensajeError .innerHTML="El pool ya está "+estado;
        }
        else{
          var myModal = new bootstrap.Modal(document.getElementById('modalExito'));
          myModal.show();
          mensajeExito.innerHTML="El pool está ahora "+estado;
          console.log("holaaaa")
        }
  
      })
      .catch(error => {
        alert("Error en la solicitud");
      });
  }
  