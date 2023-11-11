var formularioTanteador = document.getElementById("formularioTanteador");
formularioTanteador.addEventListener("submit", function (e) {
  e.preventDefault();
  EnvioTanteador();
});

function EnvioTanteador() {
  var datos = new FormData(formularioTanteador);
  var nombreTorneo = datos.get("nombreTorneo");
  var existe=datosIngresados(nombreTorneo)
  if(existe){
    alert ("ingrese un torneo para continuar");
  }
  else{
    alert("nombre del torneo:" + nombreTorneo);
    localStorage.setItem('nombreTorneo', nombreTorneo); 
    window.location.href="../Participante/ElegirParticipante.html"
  }
}

function datosIngresados(dato){
 if(dato.includes("Ingrese")){
  return true
 }
 else{
  false
 }
}
