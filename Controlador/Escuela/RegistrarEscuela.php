<?php
require_once ("../../Modelo/Escuela/EscuelaArray.php");
$nombre=$_POST['nombre'];
$tecnica=$_POST['tecnica'];
$escuelas=new EscuelaArray();
$existeEscuela=$escuelas->existeEscuela($nombre);
if($existeEscuela){
    return true;
}
else{
    $escuelas->guardar($tecnica,$nombre);
    return false;
}
?>