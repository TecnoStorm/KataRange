<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/informacion.css">
    <title>Document</title>
</head>
<body>
<?php
session_start();
include "../Modelo/Participante/ParticipanteArray.php";
$ci;
$notaFinal;    
if(isset($_SESSION["ci"]) && isset($_SESSION["notaFinal"])){
    $ci=$_SESSION["ci"];
    $notaFinal=$_SESSION["notaFinal"];
}
$participanteArray=new ParticipanteArray();
echo "<div id='contenedor'>";
$participanteArray->mostrarInfo($ci,$notaFinal);
echo "</div>";
?> 
<div id="salir">
<a href="Juez/OpcionesJuez.php" id="Volver"> Volver </a>
</div>
</body>
</html>

