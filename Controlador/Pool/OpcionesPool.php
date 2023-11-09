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
$id=$_POST["id"];
$estado=$_POST["estado"];
$poolArray=new PoolArray();
$existe=$poolArray->mismoEstado($id,$estado);

if($existe){
    echo "<p> El pool ya esta " . $estado . "</p>";
}
else{
    $poolArray->EditarPool($id, $estado); 
    echo ("<p style='color:green'>El pool: ".$id." esta: ".$estado . " reinicie la pagina para ver los cambios </p>");
}
?>
</body> 
</html>
