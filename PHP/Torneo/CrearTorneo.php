<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
include "TorneoArray.php";
$fecha=$_POST["fecha"];
$formatoFecha=date("Y-m-d", strtotime($fecha));
$categoria=$_POST["categoria"];
$cantParticipantes=$_POST["cantidad"];
$estado="cerrado";
$paraPakarate=$_POST['paraKarate'];
$sexo=$_POST['sexo'];
$torneos=new TorneoArray();
$torneos->guardar($formatoFecha,$categoria,$cantParticipantes,$estado,$paraPakarate,$sexo);
echo ("torneo creado correctamente");
?>
<a href="MostrarTorneo.php"> Mostrar Torneos</a>
</body>
</html>
