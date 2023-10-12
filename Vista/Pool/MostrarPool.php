<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Vista/CSS/Pools/MostrarPool.css">
</head>
<body>
<?php
echo "<section id='contenedor-total'>";
include "../../Modelo/Pool/PoolArray.php";
require_once ("../../Modelo/Torneo/TorneoArray.php");
require_once ("../../Modelo/Participante/ParticipanteArray.php");
session_start();
$torneos= new TorneoArray();
$pools=new PoolArray();
$participantes=new ParticipanteArray();
$idTorneo=$_POST['idTorneo'];
$pools->AsignarPool($idTorneo);
$pools->MostrarAsignados($idTorneo); 
$_SESSION['pools']=serialize($pools);
echo "</section>";
?>
</body>
</html>
