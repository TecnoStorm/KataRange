<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../CSS/Juez/MostrarJuez.css">
</head>
<body>
<?php
include "JuezArray.php";
$juezArray= new JuezArray();
$juezArray->listar();
?>
<div id="salir">
<a href="OpcionesJuez.php" id="Volver"> Volver </a>
</div>
</body>
</html>
