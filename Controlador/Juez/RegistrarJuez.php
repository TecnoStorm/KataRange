<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/Juez/RegistrarJuez.css">
    <title>Document</title>
</head>
<body>
<?php
include "../../Modelo/Juez/JuezArray.php";
require_once ("../../Modelo/Torneo/TorneoArray.php");
$torneos=new TorneoArray();
$nombre=$_POST["nombre"]; 
$apellido=$_POST["apellido"];
$usuario=$_POST["usuario"];
$ci=$_POST["ci"];
$clave=$_POST["clave"];
$confirmacion=$_POST["confirmacion"];
$nombreTorneo=$_POST['nombreTorneo'];
$torneo=$torneos->infoTorneo($nombreTorneo);
$juezArray=new JuezArray();
if($clave==$confirmacion){
    $juezArray->guardar($nombre,$apellido,$usuario,$ci,$clave,$torneo->getIdTorneo());
}
else{
    echo ("<p style='color: red; font-size: 25px'>las contraseñas no coinciden</p>");
}

?>   
</body>
</html>
