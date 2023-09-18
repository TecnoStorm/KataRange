<?php
include "../../Modelo/Torneo/TorneoArray.php";
require_once ("../../Modelo/Participante/ParticipanteArray.php");
$id=$_POST["id"];
$puesto="null";
$cinturon="null";
$participantes=new ParticipanteArray();
$torneos=new TorneoArray();
$participantesAsignados=$torneos->participantesAsignados($id);
$existeTorneo=$torneos->existeTorneo($id);

if($existeTorneo){
    
    if(!$participantesAsignados){
        
        $participantesMismaCategoria=$torneos->mismaCategoria();
        for($x=0;$x<count($participantesMismaCategoria);$x++){
                $torneos->ParticipantesTorneo($participantesMismaCategoria[$x]->getCi(),$id,$puesto,$cinturon);
            }
            echo "<p style='color: green'> Participantes Asignados correctamente </p>";
    }
    else{
        echo  "<p style='color: #B9CF34'> participantes ya asignados </p>";
    }
}
else{
    echo "<p style='color: red'> no existe el torneo </p>";
}

?>