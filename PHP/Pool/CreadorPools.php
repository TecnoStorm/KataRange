<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
include "PoolArray.php";
require_once ("../Participante/ParticipanteArray.php");
$pool = new PoolArray();
$pool->CrearPool();
$pool->listar();
$participanteArray= new ParticipanteArray();
$arrayParticipante=$participanteArray->devolverArray();
shuffle($arrayParticipante);
?>
<form action="OpcionesPool.php" method="post">
    <input type="number" placeholder="IdPool" name="id">
    <select name="estado">
        <option value="abierto">Abierto</option>
        <option value="cerrado">Cerrado</option>
    <input type="submit" value="enviar">
</select>
<a href="MostrarPool.php">Sorteo</a> 
</form>
</body>
</html>

