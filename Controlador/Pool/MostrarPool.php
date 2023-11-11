<?php
session_start();
echo "<section id='contenedor-total'>";
include "../../Modelo/Pool/PoolArray.php";
require_once ("../../Modelo/Torneo/TorneoArray.php");
require_once ("../../Modelo/Participante/ParticipanteArray.php");
$torneos= new TorneoArray();
$pools=new PoolArray();
$participantes=new ParticipanteArray();
$idTorneo=$_POST['idTorneo'];
$pools->AsignarPool($idTorneo);
echo "<section id='contenedorTabla'>";
$pools->MostrarAsignados($idTorneo); 
echo "</section>";
$_SESSION['pools']=serialize($pools);
echo "</section>";
?>

