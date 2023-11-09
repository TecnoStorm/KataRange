<?php
include "../../Modelo/Torneo/TorneoArray.php";
$nombre=$_POST["nombreEvento"];
$torneos=new TorneoArray();
$existe=$torneos->CrearEvento($nombre);

if(!$existe){
    echo "el evento ya existe";
}
else{
    echo "evento creado";
}

?>