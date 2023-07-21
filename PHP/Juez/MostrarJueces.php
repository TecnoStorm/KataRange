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
$juezArray=new JuezArray();
echo "<div id='contenedor'>";
echo "<h1> Lista de Jueces</h1>";
echo "<table border='1'>";
echo "<tr> <td> Nombre </td> <td> apellido </td> <td> CI </td> </tr>";
$juezArray->listar();
echo "</table>";
echo "</div>";
?>
<a href="OpcionesJuez.php" id="Volver"> Volver </a>
</body>
</html>
