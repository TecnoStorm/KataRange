<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Vista/CSS/Pools/CreadorPools.css">
    <link rel="stylesheet" href="../../Vista/CSS/Idioma.css">
    <title>Document</title>
</head>
<body>
<section id='contenedorIdioma'>
<p>es</p>
<input type="checkbox" id="idioma">
<p>in</p>
</section>
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
$nombres=$torneos->nombresTorneo();
$usuario=$_SESSION['usuario'];
$ciJuez=$jueces->obtenerCi($usuario);
$idTorneo=$jueces->obtenerIdTorneo($ciJuez);
$pool->listar($idTorneo);
$participanteArray= new ParticipanteArray();
$arrayParticipante=$participanteArray->devolverArray();
shuffle($arrayParticipante);
echo "</section>";
echo "<section id='formularios'>";
echo "<form action='MostrarPool.php' method='post'>";
echo  "<select name='nombreTorneo'>";
foreach($nombres as $nombre){
    echo "<option value='$nombre'> $nombre </option>";
}
echo  "</select>";
echo "<input type='submit' value='Sorteo' class='TraducirValue'>";
echo "</form>";
echo "<form id='formularioCrear'>";
echo  "<select name='nombreTorneo'>";
foreach($nombres as $nombre){
    echo "<option value='$nombre'> $nombre </option>";
}
echo  "</select>";
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
</section>
<script src="../../Controlador/js/CreadorPool.js"></script>
<script src="../../Controlador/js/traduccion.js"> </script>
<script src="../../Controlador/js/AsignadorPool.js"> </script>
</body>
</html>