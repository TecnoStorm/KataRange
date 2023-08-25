<?php
include "TorneoArray.php";
$id=$_POST["id"];
$estado=$_POST['estado'];
$puesto="null";
$cinturon="null";
$torneos=new TorneoArray();
$torneos->cambiarEstado($id,$estado);
echo ("el torneo ahora esta:".$estado);
?>