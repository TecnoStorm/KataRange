var FormularioBorrar=document.getElementById("FormularioBorrar")
var mensajeBorrar=document.getElementById("mensajeBorrar"); 
var mensajeErrorBorrar=document.getElementById("mensajeErrorBorrar");
function confimarCiBorrar(ci){
  var expresionRegular = /^[0-9]{8}$/;
  if(!expresionRegular.test(ci)){ 
    return false  
  }
  else{
    return true;
  }
} 

FormularioBorrar.addEventListener('submit',function(e){
    e.preventDefault();
    EnvioBorrar();
})
function EnvioBorrar(){
  var ci=document.getElementById("ciBorrar"); 
  var cedulaValida=confimarCiBorrar(ci.value);
    if(cedulaValida){  
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
  else{
    mensajeErrorBorrar.innerHTML="ingrese una cedula valida";
  }
}