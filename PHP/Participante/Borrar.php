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
define('SERVIDOR', '127.0.0.1');
define('USUARIO', 'root');
define('PASS', '');
define('BD', 'cuk');


$conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);

   if (!$conexion) {
       die('Error en la conexión: ' . mysqli_connect_error());
   }
   $consulta = $conexion ->prepare(
       "DELETE FROM persona WHERE ci=?");
include "ParticipanteArray.php";
$consulta2 = $conexion ->prepare(
    "DELETE FROM Participante WHERE ciP=?");
$ci=$_POST["ciBorrar"];
$participanteArray= new ParticipanteArray();
$participanteArray->eliminarParticipante($ci);
$consulta->bind_param("i", $ci);
    $consulta->execute();
    $consulta->close();
    if (!$consulta) {
        die('Error en la consulta 1: ' . $conexion->error);
    }
    $consulta2->bind_param("i", $ci);
    $consulta2->execute();
    $consulta2->close();
    $conexion->close();
?>
<div id="salir"> 
<a href='../index.php'>Volver</a>
</div>
</body>
</html>







