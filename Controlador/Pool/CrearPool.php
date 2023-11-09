<?php
require_once ("../../Modelo/Torneo/TorneoArray.php");
require_once ("../../Modelo/Participante/ParticipanteArray.php");
$pools=new PoolArray();
$torneos= new TorneoArray();
$idTorneo=$_POST['idTorneo'];
$participantes=new ParticipanteArray();
$cantParticipantes=$participantes->cantParticipantesTorneo($idTorneo);
$pools->CrearPool($idTorneo,$cantParticipantes);
echo "<p>pools creados correctamente</p>";
?> 