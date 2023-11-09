var formularioEnvioPool = document.getElementById("formularioPool");

formularioEnvioPool.addEventListener("submit", function (e) {
  e.preventDefault();
  EnvioPool();
});

function EnvioPool() {
  var datos = new FormData(formularioEnvioPool);
  var nombreTorneo = datos.get("nombreTorneo");
  localStorage.setItem('nombreTorneo', nombreTorneo); 
  window.location.href="../Pool/CreadorPools.html"

}
