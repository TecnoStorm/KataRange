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
require_once("notaArray.php");
$torneos=new TorneoArray();
$notas=new NotaArray();
$participantes=new ParticipanteArray();
$contador=$participantes->participanteAPuntuar();
$existe=$participantes->existe0();
if(!$existe){
    $notas->ganadores();
}
else{
$cantNotas=$participantes->cantidadNotas($contador);
if($cantNotas){
    $participantes->borrarNotas();
}
$ciParticipantes=$torneos->ciParticipantesTorneo();
$participantes->devolverInfo($ciParticipantes[$contador]); 
echo "<form id='formularioNotas'>";
echo "<input type='number' min='5' max='10' step='0.1' name='nota' placeholder='Nota' id='nota'>";
echo "<input type='submit' value='Enviar'>";
echo "</form>";
echo "<p id='mensajeNotas'></p>";
}
echo "<script src='../../js/Notas.js'></script>"
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js%22%3E%22%3E</script>
</body>
</html>