<?php
include "TorneoArray.php";
$id=$_POST["id"];
$estado=$_POST['estado'];
$torneos=new TorneoArray();
$torneos->cambiarEstado($id,$estado);
?>