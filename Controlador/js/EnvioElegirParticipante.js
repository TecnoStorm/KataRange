var formularioTanteador = document.getElementById("formularioTanteador");
formularioTanteador.addEventListener("submit", function (e) {
  e.preventDefault();
  EnvioTanteador();
});

function EnvioTanteador() {
  var datos = new FormData(formularioTanteador);
  var nombreTorneo = datos.get("nombreTorneo");
  alert("nombre del torneo:" + nombreTorneo);
  localStorage.setItem('nombreTorneo', nombreTorneo); 
  window.location.href="../Participante/ElegirParticipante.html"
}
