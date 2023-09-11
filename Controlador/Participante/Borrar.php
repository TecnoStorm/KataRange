<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Vista/CSS/Participante/Borrar.css">
    <title>Document</title>
</head>
<body>
<?php
require_once ("../../Modelo/Participante/ParticipanteArray.php");
$ci=$_POST["ciBorrar"];
$participantes=new ParticipanteArray();
$participantes->eliminarParticipante($ci);
$participantes->eliminarPersona($ci);
?>
</body>
</html>







