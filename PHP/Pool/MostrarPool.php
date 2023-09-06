<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/Pools/MostrarPool.css">
</head>
<body>
<?php
echo "<section id='contenedor-total'>";
include "PoolArray.php";
require_once ("../Torneo/TorneoArray.php");
require_once ("../Participante/ParticipanteArray.php");
session_start();
$torneos= new TorneoArray();
$pools=new PoolArray();
$participantes=new ParticipanteArray();
$nombreTorneo=$_POST['nombreTorneo'];
$torneo=$torneos->infoTorneo($nombreTorneo);
$pools->AsignarPool($torneo->getIdTorneo());
$pools->MostrarAsignados(); 
$_SESSION['pools']=serialize($pools);
echo "</section>";
?>
</body>
</html>
