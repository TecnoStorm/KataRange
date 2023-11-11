var formulario = document.getElementById("registrarParticipante");
var mensaje = document.getElementById("mensaje");
var mensajeError = document.getElementById("mensajeErrorCedula");
var mensajeExito = document.getElementById("mensajeExito");
var mensajeSelect = document.getElementById("mensajeSelect");
formulario.addEventListener("submit", function (e) {
  e.preventDefault();
  EnvioRegistrarParticipante();
});

function confimarCi(ci) {
  var expresionRegular = /^[0-9]{8}$/;
  if (!expresionRegular.test(ci)) {
    return false;
  } else {
    return true;
  }
}

function EnvioRegistrarParticipante() {
  var ci = document.getElementById("ci");
  var cedulaValida = confimarCi(ci.value);
  var datos = new FormData(formulario);
  var ci = datos.get("ci");
  var nombre = datos.get("nombre");
  var apellido = datos.get("apellido");
  var categoria = datos.get("categoria");
  var sexo = datos.get("sexo");
  var condicion = datos.get("Condicion");
  var nombreTorneo = datos.get("nombreTorneo");
  var tecnica = datos.get("tecnica");
  var nombreEscuela = datos.get("nombreEscuela");
  var datosPuestos = verificarSelect(categoria, sexo, condicion, nombreTorneo);
  if (cedulaValida) {
    if (datosPuestos) {
      var myModal = new bootstrap.Modal(document.getElementById("exampleModal"));
      myModal.show();
      mensajeError.innerHTML ="Ingrese todos los datos";
    } else {
      var formData = new FormData();
      formData.append("ci", ci);
      formData.append("nombre", nombre);
      formData.append("apellido", apellido);
      formData.append("categoria", categoria);
      formData.append("sexo", sexo);
      formData.append("Condicion", condicion);
      formData.append("nombreTorneo", nombreTorneo);
      formData.append("tecnica", tecnica);
      formData.append("nombreEscuela", nombreEscuela);

      fetch("../../Controlador/Participante/Registrar.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Hubo un problema con la solicitud");
          }
          return response.text();
        })
        .then((data) => {
          if (data.includes("no cumple los requisitos del torneo indicado")) {
            var myModal = new bootstrap.Modal(document.getElementById("exampleModal"));
            myModal.show();
            mensajeError.innerHTML ="No cumple los requisitos del torneo indicado";
          }
          if (data.includes("participante ingresado")) {
            var myModal = new bootstrap.Modal(document.getElementById("modalExito"));
            myModal.show();
            mensajeExito.innerHTML = "Participante ingresado con éxito";
          }
        })
        .catch((error) => {
          alert("Error en la solicitud");
        });
    }
  } else {
    var myModal = new bootstrap.Modal(document.getElementById("exampleModal"));
    myModal.show();
    mensajeError.innerHTML = "Ingrese cédula válida";
  }
}
function verificarSelect(categoria, sexo, condicion, torneo) {
  if (
    categoria.includes("Ingrese") ||
    sexo.includes("Ingrese") ||
    condicion.includes("Ingrese") ||
    torneo.includes("Ingrese")
  ) {
    alert(categoria + sexo + condicion + torneo);
    return true;
  } else {
    return false;
  }
}
