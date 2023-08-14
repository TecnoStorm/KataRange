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
include "PHP/Torneo/TorneoArray.php";
$torneos=new TorneoArray();
$torneoActivo=$torneos->abierto();
if($torneoActivo){
  echo "no se puede ingresar participantes hasta que termine el torneo";
}
else{


echo "<div id='registrar'>";
echo  "<h1> Registrar Participantes</h1>";
echo  "<form action='http://127.0.0.1/ProgramaPhp/PHP/Participante/Registrar.php' method='Post'>";
  echo  "<div class='registrar-contenedor'>";
  echo  "<div class='registrar1'>";
  echo    "<input type='number' name='ci' placeholder='CI'>";
  echo    "<input type='text' name='nombre' placeholder='Nombre'>";
  echo    "<input type='text' name='apellido' placeholder='Apellido'>";
  echo  "</div>";
  echo  "<div class='registrar1'>";
  echo   "<select name='categoria' class='opcion2'> Categoria";
  echo      "<option value='12/13'>12/13</option>";
  echo      "<option value='14,15'>14/15</option>";
  echo      "<option value='16/17'>16/17</option>";
  echo      "<option value='Mayores'>Mayores</option>";
  echo    "</select>";
  echo   " <input type='number' placeholder='Id kata' min='1' max='102' name='idKata' class='opcion2'>";
  echo   " <select name='sexo' class='opcion2'>";
  echo      "<option value='masculino'>Masculino</option>";
  echo      "<option value='Femenino'>Femenino</option>";
  echo   "</select>";
  echo    '<select name="Condicion">';
  echo     '<option value="ninguna">Ninguna</option>';
  echo     '<option value="K10"> K10</option>';
  echo     '<option value="K21"> K21</option>';
  echo     '<option value="K22"> K22</option>';
  echo     '<option value="K30"> K30</option>';
  echo    '</select>';
  echo  "</div>";
  echo  "</div>";
  echo "<input type='submit' name='registrar' value='Registrar' id='btnregistrar'>";
  echo "<a href='http://127.0.0.1/ProgramaPhp/PHP/Participante/Mostrar.php'> Mostrar</a>";
  echo  "</form>";
  echo "</div>";
  echo "</div>";
  echo '<div id="borrar">';
  echo "<h1>Borrar participante</h1>";
  echo '<form action="PHP/Participante/Borrar.php" method="post">';
  echo  '<input type="number" name="ciBorrar" placeholder="CI">';
  echo '<input type="submit" name="Borrar" value="Borrar">';
  echo "</form>";
  echo "</div>";
  echo '<div id="salir">';
  echo  '<a href="PHP/index.php" id="Volver"> Volver</a>';
  echo  "</div>";
}
?>
</body>
</html>