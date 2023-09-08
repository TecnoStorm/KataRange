<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/Pools/CreadorPools.css">
    <title>Document</title>
</head>
<body>
<?php
echo "<section id='contenedor-tabla'>";
include "PoolArray.php";
require_once ("../Participante/ParticipanteArray.php");
require_once ("../Torneo/TorneoArray.php");
$pool = new PoolArray();
$torneos=new TorneoArray();
$nombres=$torneos->nombresTorneo();
$pool->listar();
$participanteArray= new ParticipanteArray();
$arrayParticipante=$participanteArray->devolverArray();
shuffle($arrayParticipante);
echo "</section>";
echo "<form action='MostrarPool.php' method='post'>";
echo  "<select name='nombreTorneo'>";
       foreach($nombres as $nombre){
       echo "<option value='$nombre'> $nombre </option>";
       }
echo  "</select>";
echo "<input type='submit' value='Sorteo'>";
echo "</form>";
echo "<form id='formularioCrear'>";
echo  "<select name='nombreTorneo'>";
       foreach($nombres as $nombre){
       echo "<option value='$nombre'> $nombre </option>";
       }
echo  "</select>";
echo "<input type='submit' value='Crear'>";
echo "</form>";
echo "<p id='mensajeCrear'></p>";
echo "<form id='formularioMostrarPool'>";
echo  "<select name='nombreTorneo'>";
       foreach($nombres as $nombre){
       echo "<option value='$nombre'> $nombre </option>";
       }
echo "<input type='submit' value='mostrar'>";
echo "</form>";
echo "<form id='formularioGuardarPool'>";
echo  "<select name='nombreTorneo'>";
       foreach($nombres as $nombre){
       echo "<option value='$nombre'> $nombre </option>";
       }
echo "<input type='submit' value='guardar'>";
echo "<p id='mensajePoolsTorneos'></p>";
echo "<p id='mensajeMostrarPool'> </p>";
echo "</form>";

?>
</section>
<script src="../../js/PoolsTorneo.js"></script>
<script src="../../js/MostrarPool.js"></script>
<script src="../../js/AsignadorPool.js"></script>
<script src="../../js/CreadorPool.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js%22%3E"></script>
</body>
</html>

