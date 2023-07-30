<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/Participante/MostrarParticipante.css">
    <title>Document</title>
</head>
<body>
<?php
include 'ParticipanteArray.php';
$participanteArray=new ParticipanteArray();
echo "<table border='1'>
<tr><td> Nombre </td><td> Apellido </td><td> CI </td><td> Sexo </td><td> Categoria </td><td> IdKata </td></tr>";
$participanteArray->listar();
echo "</table>";
?>
<div id="salir">
<a href="http://127.0.0.1/ProgramaPhp/Participantes.html" id="Volver"> Volver</a>
</div>
</body>
</html>
