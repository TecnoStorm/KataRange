<?php
session_start();
echo "<section id='contenedor-tabla'>";
include "../../Modelo/Pool/PoolArray.php";
require_once ("../../Modelo/Participante/ParticipanteArray.php");
require_once ("../../Modelo/Torneo/TorneoArray.php");
require_once("../../Modelo/Juez/JuezArray.php");
$pool = new PoolArray();
$torneos=new TorneoArray();
$jueces=new JuezArray();
if(isset($_SESSION['nombreTorneo'])){
    $_SESSION['nombreTorneo']=$nombreTorneo;
}
$nombreTorneo=$_POST['nombreTorneo'];

$torneo=$torneos->infoTorneo($nombreTorneo);
$nombres=$torneos->nombresTorneo();
$usuario=$_SESSION['usuario'];
$ciJuez=$jueces->obtenerCi($usuario);
$idTorneo=$jueces->obtenerIdTorneo($ciJuez);
$pool->listar($torneo->getIdTorneo());
$participanteArray= new ParticipanteArray();
$arrayParticipante=$participanteArray->devolverArray();
shuffle($arrayParticipante);
echo "</section>";
echo "<section id='formularios'>";
echo "<form id='formularioAsignados'>";
echo "<input type='hidden' name='idTorneo' id='idTorneo' value='".$torneo->getIdTorneo()."'>";
echo "<input type='submit' value='Sorteo' class='TraducirValue'>";
echo "</form>";
echo "<form id='formularioCrear'>";
echo "<input type='hidden' name='idTorneo' value='".$torneo->getIdTorneo()."'>";
echo "<input type='submit' value='Crear' class='TraducirValue'>";
echo "</form>";
echo "</section>";
echo "<form id='formularioPool'>";
echo "<input type='number' placeholder='idPool' name='id'>";
echo "<select name='estado' id='estado'>";
echo "<option value='abierto' class='Traducir'> Abierto </option>";
echo "<option value='cerrado' class='Traducir'> Cerrado </option>";
echo "</select>";
echo "<input type='submit' value='enviar' class='TraducirValue'>";
echo "</form>";
echo "<p id='mensaje'></p>";
echo "<p id='mensajeCrear'></p>";

?>
