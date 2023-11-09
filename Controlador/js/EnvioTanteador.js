var formularioTanteadorCi = document.getElementById("formularioTanteadorCi");
formularioTanteadorCi.addEventListener("submit", function (e) {
  e.preventDefault();
  EnvioTanteadorCi();
});

function EnvioTanteadorCi() {
  var datos = new FormData(formularioTanteadorCi);
  var ciParticipante = datos.get("ciParticipante");
  localStorage.setItem('ciParticipante', ciParticipante); 
  window.location.href="../Participante/tanteador.html"
}
