var formularioJuez=document.getElementById("formularioJuez")
var mensajeJuez=document.getElementById("mensajeJuez");
var mensajeError=document.getElementById("mensajeErrorCedula");
var mensajeExito=document.getElementById("mensajeExito");
formularioJuez.addEventListener('submit',function(e){
    e.preventDefault();
    Envio();
})
function Envio() {
  var datos = new FormData(formularioJuez);
  var clave = datos.get('clave');
  var valida=ClaveValida(clave);
    if(valida){
      var nombre = datos.get('nombre');
      var apellido = datos.get('apellido');
      var usuario = datos.get('usuario');
      var ci = datos.get('ci');
      
      var confirmacion = datos.get('confirmacion');   
      var nombreTorneo=datos.get('nombreTorneo');
      var existe=DatosPuestos(nombreTorneo);
      if(existe){
      alert("ingrese todos los datos");
      console.log("ingrese todos los datos");
      }
      else{
        var formData = new FormData();
      formData.append('nombre', nombre);
      formData.append('apellido', apellido);
      formData.append('usuario', usuario);
      formData.append('ci', ci);
      formData.append('clave', clave);
      formData.append('confirmacion', confirmacion);
      formData.append('nombreTorneo',nombreTorneo);
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
          if(data.includes("las contraseñas no coinciden")){
            var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
            myModal.show();
            mensajeError.innerHTML="Las contraseñas no coinciden"
          }
          if(data.includes("juez ingresado")){
            var myModal = new bootstrap.Modal(document.getElementById('modalExito'));
            myModal.show();
            mensajeExito.innerHTML="Juez ingresado correctamente"
          }
        })
        .catch(error => {
          alert("Error en la solicitud");
        });
    }
      }
    else{
      var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
      myModal.show();
       mensajeError.innerHTML= `<p>La contraseña no cumple con los requisitos minimos.</p>
       <p>Requisitos minimos de la Contraseña: </p>
<ul style="padding-inline-start: 0px;">
<li>6 caracteres</li>
<li>1 mayuscula</li>
<li>1 numero</li>
     </ul> `
    }  
  }

function ClaveValida(clave){
  if (clave.length >= 6) {
      var tieneNumero = false;
      var tieneMayuscula = false;
      for (var x = 0; x < clave.length; x++) {
          var letra = clave.charAt(x);
          if (!isNaN(letra)) {
              tieneNumero = true;
          } else if (letra == letra.toUpperCase()) {
              tieneMayuscula = true;
          }
      }
      if (tieneNumero && tieneMayuscula) {
        return true
      } else {
         return false
      }
  } else {
      return false;
  }
}

function DatosPuestos (torneos){
  if(torneos.includes("Ingrese")){
    return true
  }
  return false;
}