<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://127.0.0.1/ProgramaPhp/CSS/Estilos.css">
    <title>Document</title>
</head>
<body>
<main>
<?php    
session_start();
if (isset($_GET['borrar']) && $_GET['borrar'] === 'true') {
session_destroy();
}
 echo   "<div id='contenedor'>";
 echo  " <h1> Gestión de Usuarios</h1>";
 echo   "<p> Si queres entrar al torneo presiona aqui</p>";
 echo   " <a href='http://127.0.0.1/ProgramaPhp/Participantes.html'> Ingresar participante</a>";
 echo  " <p> Si es juez registrese o ingrese su usuario</p>";
 echo   "<form action='http://127.0.0.1/ProgramaPhp/PHP/Juez/OpcionesJuez.php' method='post'>";
 echo   " <input type='text' name='usuario' placeholder='usuario'>";
 echo   " <input type='password' name='clave' placeholder='contraseña'>";
 echo  " <input type='submit' name='login' value='login'>";
 echo   "</form>";
 echo  " <a href='http://127.0.0.1/ProgramaPhp/RegistrarJuez.html'> Registrar juez </a>";
 echo "</div>";
 echo "</main>";
?>
</body>
</html>