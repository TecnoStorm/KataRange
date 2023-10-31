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
<p>es</p>
<input type="checkbox" id="idioma">
<p>en</p>
</section>
<?php
session_start();
require_once("../../Modelo/Participante/ParticipanteArray.php");
require_once ("../../Modelo/Torneo/TorneoArray.php");
require_once("../../Modelo/Nota/notaArray.php");
require_once("../../Modelo/Juez/JuezArray.php");
require_once("../../Modelo/Kata/KataArray.php");
$katas=new KataArray();
$torneos=new TorneoArray();
$jueces=new JuezArray();
$participantes=new ParticipanteArray();
$ciParticipantes=$torneos->ciParticipantesTorneo();
$contador=$participantes->participanteAPuntuar();
$idP=$participantes->obtenerPool($ciParticipantes[$contador]);
$cantidad=$participantes->notasParticipante($ciParticipantes[$contador],$idP);
$usuario=$_SESSION['usuario'];
$ciJ=$jueces->obtenerCi($usuario);
$idT=$jueces->obtenerIdTorneo($ciJ);
$existe=$participantes->existe0($idT);
$sinAsignar=$katas->sinAsignarKata($idT);
if($sinAsignar){
    echo "todos los participantes deben tener un kata asignado";
}
else{
    $notas=new NotaArray();
    if(!$existe){
        $notas->ganadores($idT); 
    }
    else{
    $cantNotas=$participantes->cantidadNotas($ciParticipantes[$contador],$idP);
    $participante=$participantes->devolverInfo($ciParticipantes[$contador]);
    if($cantidad==5){
      echo "<h1> Nota Extra </h1>";
    }
    echo "<p class='nombre'>" .$participante->getNombre(). " " . $participante->getApellido() ."</p>";
    echo '<form id="formularioNotas">
    <section class="contenedor-total">
    <section class="contenedor-nota"><svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="resta2" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
  <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
</svg>
    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="resta1" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
</svg>
';
    echo "<input type='number' min='5' max='10' step='0.1' name='nota' placeholder='Nota' id='nota' class='TraducirInput'>";
    echo '<svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="cur<svg xmlns="httprentColor" class="aumento1" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
  </svg>
  <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="aumento2" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"/>
  <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"/>
</svg></section>';
    echo "<input type='submit' value='ENVIAR' class='TraducirValue'>";
    echo "</section</form>";
    echo "<p id='mensajeNotas'></p>";
    }
    echo "<script src='../../Controlador/js/Notas.js'></script>";

}
?>
<script src="../../Controlador/js/Traduccion.js"> </script>
<script src="../../Controlador/js/CambioNota.js"> </script>
</body>
</html>