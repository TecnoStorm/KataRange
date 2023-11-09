<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/Participante/Registrar.css">
    <title>Document</title>
</head>
<body>
<?php
include "../../Modelo/Participante/ParticipanteArray.php";
require_once ("../../Modelo/Kata/KataArray.php");
require_once ("../../Modelo/Escuela/EscuelaArray.php");
require_once ("../../Modelo/Torneo/TorneoArray.php");
$nombre=$_POST['nombre'];
$ci=$_POST['ci'];
$apellido=$_POST["apellido"];
$categoria=$_POST['categoria'];
$sexo=$_POST['sexo'];
$condicion=$_POST["Condicion"];
$nombreEscuela=$_POST["nombreEscuela"];
$nombreTorneo=$_POST["nombreTorneo"];
$torneos=new TorneoArray();
$puedeParticipar=$torneos->mismaCategoriaInsectionidual($nombreTorneo,$sexo,$condicion,$categoria);
if($puedeParticipar){
    $katas=new KataArray();
    $escuelas=new EscuelaArray();
    $_participantes=new ParticipanteArray();
    $_participantes->guardar($nombre, $apellido,$ci,$sexo,$condicion,$categoria);
    $torneo=$torneos->infoTorneo($nombreTorneo);
    $escuela=$escuelas->infoEscuela($nombreEscuela);
    $escuelas->guardarParticipante($escuela->getId(),$ci);
    $torneos->ParticipantesTorneo($ci,$torneo->getIdTorneo()); 
    echo "<p style='color:red'>participante ingresado</p>";
}
else{
    echo "<p style='color:red'>no cumple los requisitos del torneo indicado</p>";
}
?>
</body>
</html>



