<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/Pools/MostrarPool.css">
</head>
<body>
<?php
echo "<section id='contenedor-total'>";
include "PoolArray.php";
session_start();
$pools=new PoolArray();
$pools->AsignarPool();
$pools->MostrarAsignados(); 
$_SESSION['pools']=serialize($pools);
echo "</section>";
?>
</body>
</html>
