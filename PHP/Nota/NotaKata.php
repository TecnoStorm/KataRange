<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/Kata/NotaKata.css">
    <title>Document</title>
</head>
<body>
<?php
session_start();
require_once("../Participante/ParticipanteArray.php");
require_once ("../Torneo/TorneoArray.php");
$torneos=new TorneoArray();
$torneoActivo=$torneos->abierto();
if($torneoActivo){
    $participantesCategoria=$torneos->mismaCategoria();
    echo "<table border='1'>";
    echo "<tr><td> Nombre </td> <td> Apellido </td><td> ci </td <td> sexo </td><td> condicion </td> <td> categoria </td> <td> idkata</td></tr>";
    foreach ($participantesCategoria as $participante) {
        echo $participante;
    }
    echo "</table>";
    echo "<form action='../Puntaje.php' method='post'>";
    echo "<input type='number', name='ci', placeholder='ci'>";
    echo "<input type='number', name='puntaje', placeholder='Puntaje' min='5' max='10' step='0.1'> ";
    echo "<input type='submit', name='enviar' value='Puntuar' id='enviar'> ";
    echo "</form>";
}
else{
    echo "torneo sin abrir";
}
?>
</body>
</html>
