<?php
require_once ("../../Modelo/Escuela/EscuelaArray.php");
$nombre=$_POST['nombre'];
$tecnica=$_POST['tecnica'];
$escuelas=new EscuelaArray();
$existeEscuela=$escuelas->existeEscuela($nombre);
if($existeEscuela){
    echo "<p style='color:yellow'>ya esta registrada la escuela</p>";
}
else{
    $escuelas->guardar($tecnica,$nombre);
    echo "<p style='color:green'> escuela ingresada con exito</p>";
}
?>