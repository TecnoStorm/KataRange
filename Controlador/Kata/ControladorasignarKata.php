<?php
require_once("../../Modelo/Kata/KataArray.php");
require_once("../../Modelo/Participante/ParticipanteArray.php");
$katas=new KataArray();
$participantes= new ParticipanteArray();
$idkata=$_POST['idKata'];
$ciP=$_POST['ciParticipante'];
$idTorneo=$_POST['idTorneo'];
$existe=$katas->katasUtilizados($ciP,$idTorneo,$idkata);
if($existe){
    echo "<p style='color:#EDAD14'> no se pueden repetir katas entre rondas </p>";
}
else{
    $katas->AsignarKata($idkata,$ciP);
}
?>