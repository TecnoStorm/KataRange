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
 echo '<input type="checkbox" class="checkbox-input" name="rol" value="tecnico"> Técnico';
 echo '<input type="checkbox" class="checkbox-input" name="rol" value="Juez"> Juez';
 echo "</section>";
 echo   " <input type='text' name='usuario' placeholder='Usuario' id='usuario'required class='TraducirInput'>";
 echo   " <input type='password' name='clave' placeholder='Contraseña' id='contraseña'required class='TraducirInput'>";
 echo  "<input type='submit' name='login' value='Login'>";
 echo   "</form>";
 echo "<p id='mensajeIndex'></p>";
 echo "</div>";
 echo "</main>";
?>
<script src="Controlador/js/index.js"> </script>
<script src="Controlador/js/Traduccion.js"> </script>
</body>
</html>