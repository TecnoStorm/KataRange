<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../Vista/CSS/Participante/ElegirParticipante.css">
</head>
<body>
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
<form action='tanteador.php' method='post'>     
<select name='ciParticipante'>";
foreach ($participantes as $participante) {
    $infoParticipante = $participanteArray->devolverInfo($participante->getCiP()); 
    echo "<option value='" . $participante->getCiP() . "'>" . $infoParticipante->getNombre() . " " . $infoParticipante->getApellido() . "</option>"; 
}
echo "</select>";
echo "<input type='submit' value='Seleccionar'>";
?>
<section id="salir">
<a href='../../Vista/Tecnico/opcionesTecnico.php' class="Traducir"> 
   <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' fill='currentColor' class='bi bi-box-arrow-left' viewBox='0 0 16 16'>
       <path fill-rule='evenodd' d='M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z'/>
       <path fill-rule='evenodd' d='M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z'/>
     </svg>
     Volver</a>
</section>
</body>
</html>