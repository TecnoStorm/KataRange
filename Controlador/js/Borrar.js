var FormularioBorrar=document.getElementById("FormularioBorrar")
var mensajeBorrar=document.getElementById("mensajeBorrar");
FormularioBorrar.addEventListener('submit',function(e){
    e.preventDefault();
    EnvioBorrar();
})
function EnvioBorrar(){
    var datos = new FormData(FormularioBorrar);
    var ci = datos.get('ciBorrar');
    var formData = new FormData();
    formData.append('ciBorrar', ci);
    fetch('../../Controlador/Participante/Borrar.php', {
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
        mensajeBorrar.innerHTML = data;
      })
      .catch(error => {
        alert("Error en la solicitud");
      });
  }