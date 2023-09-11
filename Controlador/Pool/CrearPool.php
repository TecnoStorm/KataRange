<?php
require_once ("../../Modelo/Torneo/TorneoArray.php");
require_once ("../../Modelo/Participante/ParticipanteArray.php");
$pools=new PoolArray();
$torneos= new TorneoArray();
$nombreTorneo=$_POST['nombreTorneo'];
$torneo=$torneos->infoTorneo($nombreTorneo);
$participantes=new ParticipanteArray();
$cantParticipantes=$participantes->cantParticipantesTorneo($torneo->getIdTorneo());
$pools->CrearPool($torneo->getIdTorneo(),$cantParticipantes);
?> 