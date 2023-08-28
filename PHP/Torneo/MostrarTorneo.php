<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../CSS/Torneo/MostrarTorneo.css">
</head>
<body>
    

<?php
echo   "<div id='contenedorTotal'>";
include "TorneoArray.php";
$torneos=new TorneoArray();
$torneos->mostrar();
echo   "</div>";
?>
</body>
</html>