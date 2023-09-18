<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Vista/CSS/Kata/NotaKata.css">
    <link rel="stylesheet" href="../CSS/Idioma.css">
    <title>Document</title>
</head>
<body>
<section id='contenedorIdioma'>
<p>Español</p>
<input type="checkbox" id="idioma">
<p>Ingles</p>
</section>
<?php
session_start();
require_once("../../Modelo/Participante/ParticipanteArray.php");
require_once ("../../Modelo/Torneo/TorneoArray.php");
require_once("../../Modelo/Nota/notaArray.php");
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
$participante=$participantes->devolverInfo($ciParticipantes[$contador]);
echo "<p class='Traducir'>participante: " .$participante->getNombre(). " " . $participante->getApellido() ."</p>";
echo "<form id='formularioNotas'>";
echo "<input type='number' min='5' max='10' step='0.1' name='nota' placeholder='Nota' id='nota' class='TraducirInput'>";
echo "<input type='submit' value='Enviar' class='TraducirValue'>";
echo "</form>";
echo "<p id='mensajeNotas'></p>";
}
echo "<script src='../../Controlador/js/Notas.js'></script>"
?>
<script src="../../Controlador/js/Traduccion.js"> </script>
</body>
</html>