var  formularioIndex=document.getElementById("formularioIndex")
var mensajeIndex=document.getElementById("mensajeIndex");
var elementosTraducir=document.querySelectorAll(".Traducir");
var elementosTraducirInput=document.querySelectorAll(".TraducirInput");
var url=''
var checkboxes = document.querySelectorAll('input[type="radio"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                if (checkbox.checked) {
                  if(checkbox.value=="tecnico"){
                    url='Vista/Tecnico/opcionesTecnico.php';
                  }
                  else{
                    url='Vista/Juez/OpcionesJuez.php';
                  } 
                }
            });
        });


formularioIndex.addEventListener('submit',function(e){
    e.preventDefault();
    EnvioIndex();
})
function EnvioIndex() {
   var datos = new FormData(formularioIndex);
    var usuario = datos.get('usuario'); 
    var clave = datos.get('clave');
    var formData = new FormData();
    var seleccionado=checkboxSeleccionado();
    if(seleccionado){
      formData.append('usuario', usuario);  
      formData.append('clave', clave);  
      fetch(url, {
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
          console.log(data);
          if(data.includes("Inicio de sesión exitoso")){
          window.location.href = url
          }
          else{
            mensajeIndex.innerHTML="Usuario o contraseña incorrectos";
          }
        })
        .catch(error => {
          console.log(error)
          alert("Error en la solicitud" + usuario + clave);
        });
    }
   else{
    mensajeIndex.innerHTML="seleccione un tipo de usuario";
   }
  }
   function checkboxSeleccionado(){
    for(var x=0; x < checkboxes.length; x++){
      if(checkboxes[x].checked){
        return true;
      }
    }
    return false;
  }

  function verClave() {
    var contraseña= document.getElementById("contraseña");
    var verContraseña = document.querySelector(".bi-eye-fill");
    var ocultarContraseña=document.querySelector(".bi-eye-slash");

    if (contraseña.type === "password") {
        contraseña.type = "text";
        verContraseña.style.display="none";
        ocultarContraseña.style.display="block";
    } 
}
function ocultarClave(){
    var contraseña= document.getElementById("contraseña");
    var verContraseña = document.querySelector(".bi-eye-fill");
    var ocultarContraseña=document.querySelector(".bi-eye-slash");
    
    if (contraseña.type === "text") {
      contraseña.type = "password";
      ocultarContraseña.style.display="none";
      verContraseña.style.display="block";
    } 
} 