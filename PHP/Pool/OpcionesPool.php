<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
include "PoolArray.php";
$id=$_POST["id"];
$estado=$_POST["estado"];
$poolArray=new PoolArray();
$existe=$poolArray->mismoEstado($id,$estado);
if($existe){
    echo "<p style='color:#EDAD14'> el pool ya esta " . $estado . "</p>";
}
else{
    $poolArray->EditarPool($id, $estado); 
    echo ("<p style='color:green'>el pool: ".$id." esta: ".$estado . " reinicie la pagina para ver los cambios </p>");
}
?>
</body> 
</html>
