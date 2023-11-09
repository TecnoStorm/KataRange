var elementosTraducir=document.querySelectorAll(".Traducir");
var elementosTraducirInput=document.querySelectorAll(".TraducirInput");
var elementosTraducirValues=document.querySelectorAll(".TraducirValue")
var existe=false;

window.onload = function() {
  var language = getCookie("language");
  if (language === "english") {
      document.getElementById('idioma').checked = true;
      funcionIdioma();
  }
};

if(elementosTraducirValues.length!=0){
  existe=true;
}
idioma.addEventListener("click",funcionIdioma)


function TraducirTexto(texto, LenguajeInicio, LenguajeFinal,elemento) {
  const apiKey = "84c05be894fb1ea52316"; 
  var apiUrl = `https://api.mymemory.translated.net/get?q=${encodeURIComponent(texto)}&langpair=${LenguajeInicio}|${LenguajeFinal}&key=${apiKey}`;
  
  var traduccion=FuncionFetch(apiUrl,elemento);
  return traduccion;
}

function TraducirTextoInput(texto, LenguajeInicio,LenguajeFinal,elementoInput) {
  const apiKey = "84c05be894fb1ea52316"; 
  var apiUrl = `https://api.mymemory.translated.net/get?q=${encodeURIComponent(texto)}&langpair=${LenguajeInicio}|${LenguajeFinal}&key=${apiKey}`;
  
  var traduccion=FuncionFetchInput(apiUrl,elementoInput);
  return traduccion;
}

if(existe){
    
  function TraducirTextoValues(texto, LenguajeInicio,LenguajeFinal,elementoValue) {
    const apiKey = "84c05be894fb1ea52316"; 
    var apiUrl = `https://api.mymemory.translated.net/get?q=${encodeURIComponent(texto)}&langpair=${LenguajeInicio}|${LenguajeFinal}&key=${apiKey}`;
    
    var traduccion=FuncionFetchValue(apiUrl,elementoValue);
    return traduccion;
  }
  
  
  function FuncionFetchValue(apiUrl,elementoValue){
    fetch(apiUrl)
    .then(response => response.json())
    .then(data => {
      if (data.responseStatus === 200) {
       translation = data.responseData.translatedText;      
        elementoValue.setAttribute("value",translation);
      } else {
        console.error('Error al traducir el texto');
      }
    })
    .catch(error => {
      console.error('Error en la solicitud:', error);
    });
      }
}


function funcionIdioma(){
  var check=idioma.checked;
  if(check){
    elementosTraducir.forEach(function(elemento) {
      TraducirTexto(elemento.textContent,"es","en",elemento)
      document.cookie = "language=english; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/"
    });
    elementosTraducirInput.forEach(function(elementoInput){
     TraducirTextoInput(elementoInput.getAttribute("placeHolder"),"es","en",elementoInput)
    })
    if(elementosTraducirValues.length!=0){
       elementosTraducirValues.forEach(function(elementoValue){
          TraducirTextoValues(elementoValue.getAttribute("value"),"es","en",elementoValue)
       })
    }
  }
  else{
    elementosTraducir.forEach(function(elemento) {
     TraducirTexto(elemento.textContent,"en","es",elemento)
     document.cookie = "language=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
    });

    elementosTraducirInput.forEach(function(elementoInput){
        TraducirTextoInput(elementoInput.getAttribute("placeHolder"),"en","es",elementoInput)
    })
  }
}

function FuncionFetch(apiUrl,elemento){
    fetch(apiUrl)
    .then(response => response.json())
    .then(data => {
      if (data.responseStatus === 200) {
       translation = data.responseData.translatedText;
        elemento.textContent=translation
      } else {
        console.error('Error al traducir el texto');
      }
    })
    .catch(error => {
      console.error('Error en la solicitud:', error);
    });
      }
      
      function FuncionFetchInput(apiUrl,elementoInput){
        fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
          if (data.responseStatus === 200) {
           translation = data.responseData.translatedText;
           elementoInput.setAttribute("placeHolder",translation);
          } else {
            console.error('Error al traducir el texto');
          }
        })
        .catch(error => {
          console.error('Error en la solicitud:', error);
        });
          }
         function getCookie(nombre) {
            var nombreCookie = nombre + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var cookieArray = decodedCookie.split(';');
            for (var i = 0; i < cookieArray.length; i++) {
                var cookie = cookieArray[i];
                while (cookie.charAt(0) === ' ') {
                    cookie = cookie.substring(1);
                }
                if (cookie.indexOf(nombreCookie) === 0) {
                    return cookie.substring(nombreCookie.length, cookie.length);
                }
            }
            return "";
        }