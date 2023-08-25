<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/Participante/Borrar.css">
    <title>Document</title>
</head>
<body>
<?php
require_once ("ParticipanteArray.php");
$ci=$_POST["ciBorrar"];
$participantes=new ParticipanteArray();
$participantes->eliminarParticipante($ci);
$participantes->eliminarPersona($ci);
echo ("participante ingresado con exito");
?>
<div id="salir"> 
<a href='../index.php'>Volver</a>
</div>
</body>
</html>







