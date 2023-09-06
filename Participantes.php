<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="CSS/Participante/Participantes.css">
</head>
<body>
<?php 
require_once ("C:/xampp/htdocs/ProgramaPhp/PHP/Torneo/TorneoArray.php");
require_once ("C:/xampp/htdocs/ProgramaPhp/PHP/Escuela/EscuelaArray.php");
$torneos=new TorneoArray();
$escuelas=new EscuelaArray();
$nombresTorneo=$torneos->nombresTorneo();
$nombres=$escuelas->nombresEscuela();
echo "<div id='registrar'>";
echo "<h1> Registrar Participantes</h1>";
echo  "<form id='registrarParticipante'>";
echo  "<div class='registrar-contenedor'>";
echo  "<div class='registrar1'>";
echo    "<input type='number' name='ci' placeholder='CI' id='ci'>";
echo    "<input type='text' name='nombre' placeholder='Nombre' id='nombre'>";
echo    "<input type='text' name='apellido' placeholder='Apellido' id='apellido'>";
echo  "</div>";
echo  "<div class='registrar1'>";
echo  "<select name='categoria' class='opcion2' id='categoria'> Categoria";
echo      "<option value='12/13'>12/13</option>";
echo      "<option value='14,15'>14/15</option>";
echo        "<option value='16/17'>16/17</option>";
echo      "<option value='mayores'>Mayores</option>";
echo  "</select>";
echo      "<input type='number' placeholder='Id kata' min='1' max='102' name='idKata' class='opcion2' id='idKata'>";
echo      "<select name='sexo' class='opcion2' id='sexo'>";
echo        "<option value='Masculino'>Masculino</option>";
echo      "<option value='Femenino'>Femenino</option>";
echo     "</select>";
echo      "<select name='Condicion' id='Condicion'>";
echo       "<option value='Ninguna'>Ninguna</option>";
echo       "<option value='K10'> K10</option>";
echo       "<option value='K21'> K21</option>";
echo       "<option value='K22'> K22</option>";
echo       "<option value='K30'> K30</option>";
echo      "</select>";
echo    "</div>";
echo    "</div>";
echo  "<select name='nombreEscuela'>";
       foreach($nombres as $nombre){
       echo "<option value='$nombre'> $nombre </option>";
       }
echo  "</select>";
echo  "<select name='nombreTorneo'>";
       foreach($nombresTorneo as $nombre){
       echo "<option value='$nombre'> $nombre </option>";
       }
echo  "</select>";
echo  "<input type='submit' name='registrar' value='Registrar' id='btnregistrar'>";
echo   "<a href='http://127.0.0.1/ProgramaPhp/PHP/Participante/Mostrar.php'> Mostrar</a>";
echo    "</form>";
echo "<h2> registrar escuela</h2>";
echo "<form id='formularioEscuela'>";
echo  "<input type='text' name='nombreEscuela' id='nombreEscuela' placeholder='Nombre de la escuela'>";
echo  "<input type='text' name='tecnica' id='nombreEscuela' placeholder='tecnica que enseña'>";
echo "<input type='submit' name='registrarEscuela' value='registrar'>";
echo "</form>";
echo "<p id='mensajeEscuela'></p>";
echo   "<p id='mensaje'></p>";
echo   "<p id='mensajeBorrar'></p>";
echo   "</div>";
echo   "</div>";
echo "<h2> Torneos disponibles </h2>";
$torneos->mostrar();
echo   "<div id='borrar'>";
echo   "<h1>Borrar participante</h1>";
echo   "<form id='FormularioBorrar'>";
echo   "<input type='number' name='ciBorrar' placeholder='CI' id='ciBorrar'>";
echo   "<input type='submit' name='Borrar' value='Borrar' id='Borrar'>";
echo   "</form>";
echo   "</div>";
echo   "<div id='salir'>";
echo    "<a href='PHP/index.php' id='Volver'> Volver</a>";
echo   "</div>";
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js%22%3E"></script>
<script src="js/RegistrarEscuela.js"> </script>
<script src="js/RegistrarParticipante.js"></script>
<script src="js/Borrar.js"> </script>
</body>
</html>
