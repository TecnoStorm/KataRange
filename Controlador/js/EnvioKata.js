var formularioEnvioKata = document.getElementById("formularioKata");

formularioEnvioKata.addEventListener("submit", function (e) {
  e.preventDefault();
  EnvioKata();
});

function EnvioKata() {
  var datos = new FormData(formularioEnvioKata);
  var nombreTorneo = datos.get("nombreTorneo");
  alert("nombre del torneo:" + nombreTorneo);
  localStorage.setItem('nombreTorneo', nombreTorneo); 
  window.location.href="AsignarKata.html"
}
