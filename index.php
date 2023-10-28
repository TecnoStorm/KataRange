<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Vista/CSS/Estilos.css">
    <link rel="stylesheet" href="Vista/CSS/Idioma.css">
    <title>Document</title>
</head>
<body>
<section id='contenedorIdioma'>
<p>Es</p>
<input type="checkbox" id="idioma">
<p>en</p>
</section>
<main>
<?php    
session_start();
if(isset($_SESSION['usuario'])){
    session_destroy();
}
 echo   "<div id='contenedor'>";
 echo  " <h1 id='titulo' class='Traducir'> Gestión de Usuarios</h1>";
 echo  " <p id='texto3'class='Traducir'> Si es un juez o tecnico ingrese con su usuario</p>";
 echo   "<form id='formularioIndex'>";
 echo "<section id='contenedorBox'>";
 echo '<input type="radio" class="checkbox-input" name="rol" value="tecnico"> Técnico';
 echo '<input type="radio" class="checkbox-input" name="rol" value="Juez"> Juez';
 echo "</section>";
 echo   " <input type='text' name='usuario' placeholder='Usuario' id='usuario'required class='TraducirInput'>";
 echo "<section id='contenedorContraseña'>";
 echo   '<input type="password" name="clave" placeholder="Contraseña" id="contraseña"required class="TraducirInput">
 <svg xmlns="http://www.w3.org/2000/svg" onclick="verClave()" width="19" height="19" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
 <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
 <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
</svg>';
echo '<svg xmlns="http://www.w3.org/2000/svg" onclick="ocultarClave()" width="19" height="19" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
<path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
<path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>
<path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>
</svg>';
 echo "</section>";
 echo  "<input type='submit' name='login' value='Login'>";
 echo "</form>";
 echo "<p id='mensajeIndex'></p>";
 echo "</div>";
 echo "</main>";
 echo '<script src="Controlador/js/index.js"> </script>';
 echo '<script src="Controlador/js/Traduccion.js"> </script>';
?>

</body>
</html>