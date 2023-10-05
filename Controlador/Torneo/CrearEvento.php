<?php
include "../../Modelo/Torneo/TorneoArray.php";
$nombre=$_POST["nombreEvento"];
$torneos=new TorneoArray();
$torneos->CrearEvento($nombre);
?>