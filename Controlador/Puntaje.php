<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/Puntaje.css">
    <title>Document</title>
</head>
<body>
<?php
session_start();
require_once ("../Modelo/Participante/ParticipanteArray.php");
require_once ("../Modelo/Juez/JuezArray.php");
require_once ("../Modelo/Torneo/TorneoArray.php");
$participantes= new ParticipanteArray();
$torneos=new TorneoArray();
$ciParticipantes=$torneos->ciParticipantesTorneo();
$contador=$participantes->participanteAPuntuar();
if(isset($_SESSION["usuario"])){
    $usuario=$_SESSION["usuario"];
}
$jueces=new JuezArray();
echo $usuario;
$ciJ=$jueces->obtenerCi($usuario);
$idP=$participantes->obtenerPool($ciParticipantes[$contador]);
$nota=$_POST['nota'];
$participantes->notas($ciJ,$ciParticipantes[$contador],$idP,$nota);
$cantNotas=$participantes->cantidadNotas($ciParticipantes[$contador]); 
if($cantNotas){
    $participantes->notaFinal($ciParticipantes[$contador]);
    $participantes->devolverInfo($ciParticipantes[$contador]); 
    echo "<a href='NotaKata.php'> Reset </a>"; 
}




?>  
</body>
</html>