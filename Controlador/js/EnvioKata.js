var formularioEnvioKata = document.getElementById("formularioKata");
var mensajeError = document.getElementById("mensajeError")

formularioEnvioKata.addEventListener("submit", function (e) {
  e.preventDefault();
  EnvioKata();
});

function EnvioKata() {
  var datos = new FormData(formularioEnvioKata);
  var nombreTorneo = datos.get("nombreTorneo");
  if(datosingresados(nombreTorneo)){
    var myModal = new bootstrap.Modal(document.getElementById("exampleModal"));
    myModal.show();
    mensajeError.innerHTML ="Ingrese un torneo";
  }
  else{
    localStorage.setItem('nombreTorneo', nombreTorneo); 
    window.location.href="AsignarKata.html"
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