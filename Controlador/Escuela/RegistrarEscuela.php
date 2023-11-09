<?php
require_once ("../../Modelo/Escuela/EscuelaArray.php");
$nombre=$_POST['nombre'];
$tecnica=$_POST['tecnica'];
$escuelas=new EscuelaArray();
$existeEscuela=$escuelas->existeEscuela($nombre);

if($existeEscuela){
    echo "<p id='mensaje'>La escuela ya esta registrada</p>";
}
else{
    $escuelas->guardar($tecnica,$nombre);
    echo "<p id='mensaje'>La escuela se ingreso con exito</p>";
}

?>