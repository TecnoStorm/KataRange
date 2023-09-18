var  formularioIndex=document.getElementById("formularioIndex")
var mensajeIndex=document.getElementById("mensajeIndex");
var elementosTraducir=document.querySelectorAll(".Traducir");
var elementosTraducirInput=document.querySelectorAll(".TraducirInput");




formularioIndex.addEventListener('submit',function(e){
    e.preventDefault();
    EnvioIndex();
})
function EnvioIndex() {
    var datos = new FormData(formularioIndex);
    var usuario = datos.get('usuario'); 
    var clave = datos.get('clave');
    var formData = new FormData();
    formData.append('usuario', usuario);  
    formData.append('clave', clave);  
    fetch('Vista/Juez/OpcionesJuez.php', {
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
        window.location.href = 'Vista/Juez/OpcionesJuez.php?usuario='+usuario+'&clave='+clave 
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
