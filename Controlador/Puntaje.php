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
require_once("../Modelo/Nota/NotaArray.php");
$participantes= new ParticipanteArray();
$torneos=new TorneoArray();
$notas=new NotaArray();
$ciParticipantes=$torneos->ciParticipantesTorneo();
$contador=$participantes->participanteAPuntuar();
if(isset($_SESSION["usuario"])){
    $usuario=$_SESSION["usuario"];
}
$jueces=new JuezArray();
echo $usuario;
$ciJ=$jueces->obtenerCi($usuario);
$idTorneo=$jueces->idTorneoJuez($ciJ);
$idP=$participantes->obtenerPool($ciParticipantes[$contador]);
$nota=$_POST['nota'];
$participante=$participantes->devolverInfo($ciParticipantes[$contador]);
$cantNotas=$participantes->notasParticipante($ciParticipantes[$contador],$idP);
if($cantNotas==5){
    $_SESSION['notaExtra']=$nota;
}
else{
    $participantes->notas($ciJ,$ciParticipantes[$contador],$idP,$nota);
    $jueces->fechaHora($ciParticipantes[$contador],$ciJ,$idP);
}
$existe=$participantes->cantidadNotas($ciParticipantes[$contador],$idP); 
if($existe && $participante->getCondicion()!="Ninguna" && isset($_SESSION['notaExtra']) || $existe && $participante->getCondicion()=="Ninguna"){
    $participantes->notaFinal($idP,$ciParticipantes[$contador]); 
    echo "<a href='NotaKata.php'> Reset </a>"; 
}




?>  
</body>
</html>