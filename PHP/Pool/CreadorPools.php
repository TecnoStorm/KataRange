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
$pool = new PoolArray();
$pool->CrearPool();
$pool->listar();
$participanteArray= new ParticipanteArray();
$arrayParticipante=$participanteArray->devolverArray();
shuffle($arrayParticipante);
echo "</section>";
?>
<section id="contenedor-formulario">
<form id="formularioPool">
    <input type="number" placeholder="IdPool" name="id">
    <select name="estado">
        <option value="abierto">Abierto</option>
        <option value="cerrado">Cerrado</option>
    <input type="submit" value="enviar">
</select>
<a href="MostrarPool.php">Sorteo</a> 
</form>
</section>
<p id="mensaje">;
<script src="../../js/AsignadorPool.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js%22%3E"></script>
</body>
</html>

