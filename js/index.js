var  formularioIndex=document.getElementById("formularioIndex")
var mensajeIndex=document.getElementById("mensajeIndex");
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
    fetch('http://127.0.0.1/ProgramaPhp/PHP/Juez/OpcionesJuez.php', {
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
        if(data.includes("inicio de sesion exitoso")){
        window.location.href = 'Juez/OpcionesJuez.php?usuario='+usuario+'&clave='+clave 
        }
        else{
          mensajeIndex.innerHTML="Usuario o contraseña incorrectos";
        }
      })
      .catch(error => {
        console.log(error)
        alert("Error en la solicitud");
      });
  }
  