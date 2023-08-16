<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/Kata/NotaKata.css">
    <title>Document</title>
</head>
<body>
<?php
session_start();
require_once("../Participante/ParticipanteArray.php");
require_once ("../Torneo/TorneoArray.php");
$torneos=new TorneoArray();
$participantes=new ParticipanteArray();
$contador=$participantes->participanteAPuntuar();

$cantNotas=$participantes->cantidadNotas($contador);
if($cantNotas){
    $participantes->borrarNotas();
}
$ciParticipantes=$torneos->ciParticipantesTorneo();
$participantes->devolverInfo($ciParticipantes[$contador]);
echo "<form action='../puntaje.php' method='post'>";
echo "<input type='number' min='5' max='10' step='0.1' name='nota' placeholder='Nota'>";
echo "<input type='submit' value='Enviar'>";
echo "</form>";
?>
</body>
</html>