<?php
include "TorneoArray.php";
require_once ("C:/xampp/htdocs/ProgramaPhp/PHP/Participante/ParticipanteArray.php");
$id=$_POST["id"];
$puesto="null";
$cinturon="null";
$participantes=new ParticipanteArray();
$torneos=new TorneoArray();
$participantesMismaCategoria=$torneos->mismaCategoria();
for($x=0;$x<count($participantesMismaCategoria);$x++){
        $torneos->ParticipantesTorneo($participantesMismaCategoria[$x]->getCi(),$id,$puesto,$cinturon);
    }
    echo ($id);
?>