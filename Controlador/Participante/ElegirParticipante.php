<?php
session_start();
require_once("../../Modelo/Torneo/TorneoArray.php");
require_once("../../Modelo/Nota/notaArray.php");
require_once("../../Modelo/Participante/participanteArray.php");
$torneos = new TorneoArray();
$notas = new notaArray();
$participanteArray = new participanteArray();
if(isset($_POST['nombreTorneo'])){
    $nombre=$_POST['nombreTorneo'];
};
if(isset($_SESSION['nombreTorneo'])){
    $nombre=$_SESSION['nombreTorneo'];
    unset($_SESSION['nombreTorneo']);
}
$_SESSION['nombreTorneo']=$nombre;
$torneo = $torneos->infoTorneo($nombre);
$participantes = $notas->notasTorneo($torneo->getIdTorneo());

echo "<h1>Seleccione un participante para mostrar su información:</h1>
<form id='formularioTanteadorCi'>;    
<select name='ciParticipante'>";
foreach ($participantes as $participante) {
    $infoParticipante = $participanteArray->devolverInfo($participante->getCiP()); 
    echo "<option value='" . $participante->getCiP() . "'>" . $infoParticipante->getNombre() . " " . $infoParticipante->getApellido() . "</option>"; 
}
echo "</select>";
echo "<input type='submit' value='Seleccionar'>";
?>
