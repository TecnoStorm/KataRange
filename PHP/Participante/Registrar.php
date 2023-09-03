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
include "ParticipanteArray.php";
require_once ("C:/xampp/htdocs/ProgramaPhp/PHP/Kata/KataArray.php");
require_once ("C:/xampp/htdocs/ProgramaPhp/PHP/Escuela/EscuelaArray.php");
require_once ("C:/xampp/htdocs/ProgramaPhp/PHP/Torneo/TorneoArray.php");
$nombre=$_POST['nombre'];
$ci=$_POST['ci'];
$apellido=$_POST["apellido"];
$categoria=$_POST['categoria'];
$sexo=$_POST['sexo'];
$idKata=$_POST['idKata'];
$condicion=$_POST["Condicion"];
$nombreEscuela=$_POST["nombreEscuela"];
$tecnica=$_POST["tecnica"];
$nombreTorneo=$_POST["nombreTorneo"];
$torneos=new TorneoArray();
$puedeParticipar=$torneos->mismaCategoriaIndividual($nombreTorneo,$sexo,$condicion,$categoria);
if($puedeParticipar){
    $katas=new KataArray();
    $escuelas=new EscuelaArray();
    $_participantes=new ParticipanteArray();
    $_participantes->guardar($nombre, $apellido,$ci,$sexo,$condicion,$categoria);
    $katas->guardarKata($ci,$idKata);
    $torneo=$torneos->infoTorneo($nombreTorneo);
    $existeEscuela=$escuelas->existeEscuela($nombreEscuela);
    if($existeEscuela){
        $escuela=$escuelas->infoEscuela($nombreEscuela);
        $escuelas->guardarParticipante($escuela->getId(),$ci);
        $torneos->ParticipantesTorneo($ci,$torneo->getIdTorneo(),0,"null");
    }
   else{
    $escuelas->guardar($tecnica,$nombreEscuela);
    $escuela=$escuelas->infoEscuela($nombreEscuela);
    $escuelas->guardarParticipante($escuela->getId(),$ci);
    $torneos->ParticipantesTorneo($ciP,$torneo->getIdTorneo(),0,"null");
   }
    echo "<div id='salir'>";
    echo "<a href='http://127.0.0.1/ProgramaPhp/Participantes.html'>Volver</a>"; 
    echo "</div>";
}
else{
    echo "no cumple los requisitos del torneo indicado";
}
?>
</body>
</html>



