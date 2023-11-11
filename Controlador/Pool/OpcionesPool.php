<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
include "../../Modelo/Pool/PoolArray.php";
require_once("../../Modelo/Torneo/TorneoArray.php");
$id=$_POST["id"];
$estado=$_POST["estado"];
$nombreTorneo=$_POST["nombreTorneo"];
$torneos=new TorneoArray();
$torneo=$torneos->infoTorneo($nombreTorneo);
$poolArray=new PoolArray();
$existe=$poolArray->mismoEstado($id,$estado);
$existePool=$poolArray->existePool($torneo->getIdTorneo(),$id);
if($existePool){
    if($existe){
        echo "<p> El pool ya esta " . $estado . "</p>";
    }
    else{
        $poolArray->EditarPool($id, $estado); 
        echo ("<p style='color:green'>El pool: ".$id." esta: ".$estado . " reinicie la pagina para ver los cambios </p>");
    }
}
else{
    echo "<p>ingrese un pool valido</p>"; 
}
?>
</body> 
</html>
