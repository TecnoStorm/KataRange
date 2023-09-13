<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://127.0.0.1/ProgramaPhp/Vista/CSS/Estilos.css">
    <title>Document</title>
</head>
<body>
<main>
<?php    
session_start();
if(isset($_SESSION['usuario'])){
    session_destroy();
}
 echo   "<div id='contenedor'>";
 echo  " <h1> Gestión de Usuarios</h1>";
 echo   "<p> Si quieres entrar al torneo presiona aqui</p>";
 echo   " <a href='Vista/Participante/FormularioParticipantes.php'> Ingresar participante</a>";
 echo  " <p> Si es juez regístrese o ingrese su usuario</p>";
 echo   "<form id='formularioIndex'>";
 echo   " <input type='text' name='usuario' placeholder='Usuario'required>";
 echo   " <input type='password' name='clave' placeholder='Contraseña'required>";
 echo  "<input type='submit' name='login' value='Login'>";
 echo   "</form>";
 echo "<p id='mensajeIndex'></p>";
 echo  " <a href='Vista/Juez/RegistrarJuez.php'> Registrar juez </a>";
 echo "</div>";
 echo "</main>";
?>
<script src="Controlador/js/index.js"> </script>
</body>
</html>