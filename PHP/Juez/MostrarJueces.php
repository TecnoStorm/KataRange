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
define('SERVIDOR', '127.0.0.1');
define('USUARIO', 'root');
define('PASS', '');
define('BD', 'cuk');

$conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
$consulta = "SELECT * FROM Juez";

$resultado = mysqli_query($conexion, $consulta);

if (!$resultado){
    die('Error en la consulta SQL: ' . $consulta);
}
echo "<table border='2'>";
echo "<tr> <td> Nombre </td> <td> apellido </td> <td> Ci </td> </td><td> sexo </td> <td> condicion</td> </tr>";
while($fila = $resultado->fetch_assoc()){
echo "<tr> <td>".$fila['nombre'] . " </td><td>" . $fila['Apellido'] . "</td><td>  " . $fila['usuario'] . "</td> <td>" . $fila['ciJ'] . "</td><td>" . $fila ['contraseña'] ."</td> </tr>";
}
echo "</table>";
?>
<div id="salir">
<a href="OpcionesJuez.php" id="Volver"> Volver </a>
</div>
</body>
</html>
