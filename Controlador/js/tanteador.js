var cinturon=document.getElementById("oculto").textContent;
var contenedor=document.querySelector(".ContenedorNota");
if(cinturon==' Ao '){
    contenedor.style.backgroundColor = "blue";
}
else{
    contenedor.style.backgroundColor = "red";
}