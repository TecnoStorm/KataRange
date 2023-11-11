var formularioEnvioPool = document.getElementById("formularioPool");
var mensajeError = document.getElementById("mensajeError")

formularioEnvioPool.addEventListener("submit", function (e) {
  e.preventDefault();
  EnvioPool();
});

function EnvioPool() {
  var datos = new FormData(formularioEnvioPool);
  var nombreTorneo = datos.get("nombreTorneo");
  alert(nombreTorneo)
  var existe=datosingresados(nombreTorneo);
  if(existe){
    var myModal = new bootstrap.Modal(document.getElementById("exampleModal"));
    myModal.show();
    mensajeError.innerHTML ="Ingrese un torneo";
  }
  else{
    localStorage.setItem('nombreTorneo', nombreTorneo); 
    window.location.href="../Pool/CreadorPools.html"
  }
}

function datosingresados(dato){
  if(dato.includes("Ingrese")){
       return true
  }
  else{
    return false
  }
}