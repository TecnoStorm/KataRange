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
include "ParticipanteArray.php";
$participantes=new ParticipanteArray();
$participantes->listar();
?>
<div id="salir">
<a href="http://127.0.0.1/ProgramaPhp/Participantes.html" id="Volver"> Volver</a>
</div>
</body>
</html>
