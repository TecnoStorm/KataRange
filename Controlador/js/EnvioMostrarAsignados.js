var formularioAsignados = document.getElementById("formularioAsignados");

formularioAsignados.addEventListener("submit", function (e) {
  e.preventDefault();
  EnvioAsignados();
});

function EnvioAsignados() {
  var datos = new FormData(formularioAsignados);
  var idTorneo = datos.get("idTorneo");
  localStorage.setItem('idTorneo', idTorneo); 
  window.location.href="../Pool/MostrarPool.html"

}
