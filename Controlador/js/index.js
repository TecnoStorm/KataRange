fetch('Controlador/index.php')
  .then(response => response.json())
  .then(data => {
    const mensajeIndex = document.getElementById('mensajeIndex');
    if (data.success) {
      mensajeIndex.textContent = 'La sesión se ha destruido correctamente.';
    } else {
      mensajeIndex.textContent = 'Ha ocurrido un error al destruir la sesión.';
    }
  })
  .catch(error => {
    console.error('Error:', error);
  });


var formularioIndex = document.getElementById("formularioIndex");
var mensajeIndex = document.getElementById("mensajeIndex");
var elementosTraducir = document.querySelectorAll(".Traducir");
var elementosTraducirInput = document.querySelectorAll(".TraducirInput");
var modalUsuario = document.querySelector(".modalUsuario");
var mensajeError = document.getElementById("mensajeError")
var url = "";
var urlphp="";
var checkboxes = document.querySelectorAll('input[type="radio"]');
checkboxes.forEach((checkbox) => {
  checkbox.addEventListener("change", () => {
    if (checkbox.checked) {
      if (checkbox.value == "tecnico") {
        url = "Vista/Tecnico/opcionesTecnico.html";
         urlphp="Controlador/Tecnico/Tecnico.php"
      } else {
        url = "Vista/Juez/OpcionesJuez.html";
        urlphp="Controlador/Juez/OpcionesJuez.php"
      }
    }
  });
});

formularioIndex.addEventListener("submit", function (e) {
  e.preventDefault();
  EnvioIndex();
});

function EnvioIndex() {
  var datos = new FormData(formularioIndex);
  var usuario = datos.get("usuario");
  var clave = datos.get("clave");
  var formData = new FormData();
  var seleccionado = checkboxSeleccionado();
  if (seleccionado) {
    formData.append("usuario", usuario);
    formData.append("clave", clave);
    fetch(urlphp, {
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
        console.log(data);
        if (data.includes("Inicio de sesión exitoso")) {
          window.location.href = url;
        } else {
          var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
          myModal.show();
          mensajeError.innerHTML="Usuario o contraseña incorrectos"
        }
      })
      .catch((error) => {
        console.log(error);
        alert("Error en la solicitud" + usuario + clave);
      });
  } else {
      var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
      myModal.show();
      mensajeError.innerHTML="Ingrese un tipo de usuario"
  }
}

function checkboxSeleccionado() {
  for (var x = 0; x < checkboxes.length; x++) {
    if (checkboxes[x].checked) {
      return true;
    }
  }
  return false;
}

function verClave() {
  var contraseña = document.getElementById("contraseña");
  var verContraseña = document.querySelector(".bi-eye-fill");
  var ocultarContraseña = document.querySelector(".bi-eye-slash");

  if (contraseña.type === "password") {
    contraseña.type = "text";
    verContraseña.style.display = "none";
    ocultarContraseña.style.display = "block";
  }
}
function ocultarClave() {
  var contraseña = document.getElementById("contraseña");
  var verContraseña = document.querySelector(".bi-eye-fill");
  var ocultarContraseña = document.querySelector(".bi-eye-slash");

  if (contraseña.type === "text") {
    contraseña.type = "password";
    ocultarContraseña.style.display = "none";
    verContraseña.style.display = "block";
  }
}
