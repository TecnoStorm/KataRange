<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
include "../../Modelo/Torneo/TorneoArray.php";
$fecha=$_POST["fecha"];
$formatoFecha=date("Y-m-d", strtotime($fecha));
$categoria=$_POST["categoria"];
$cantParticipantes=$_POST["cantidad"];
$estado="cerrado";
$paraPakarate=$_POST['paraKarate'];
$sexo=$_POST['sexo'];
$nombre=$_POST['nombre'];
$direccion=$_POST['direccion'];
$nombreEvento=$_POST['nombreEvento'];
$torneos=new TorneoArray();
$torneos->guardar($formatoFecha,$categoria,$cantParticipantes,$estado,$paraPakarate,$sexo,$nombre,$direccion,$nombreEvento);
?>
</body>
</html>
