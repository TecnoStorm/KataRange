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
include "ParticipanteArray.php";
$ci=$_POST["ciBorrar"];
$participanteArray= new ParticipanteArray();
$participanteArray->eliminarParticipante($ci);
?>  
<a href='../index.php'>Volver</a>
</body>
</html>







