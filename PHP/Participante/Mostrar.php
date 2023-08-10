<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/Participante/MostrarParticipante.css">
    <title>Document</title>
</head>
<body>
<?php
define('SERVIDOR', '127.0.0.1');
define('USUARIO', 'root');
define('PASS', '');
define('BD', 'cuk');

$conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
$consulta = "SELECT * FROM participante";

$resultado = mysqli_query($conexion, $consulta);

if (!$resultado){
    die('Error en la consulta SQL: ' . $consulta);
}
echo "<table border='2'>";
echo "<tr> <td> Nombre </td> <td> apellido </td> <td> Ci </td> </td><td> sexo </td> <td> condicion </td><td> categoria </td> <td> idKata </td> </tr>";
while($fila = $resultado->fetch_assoc()){
echo "<tr> <td>".$fila['nombreP'] . " </td><td>" . $fila['apellidoP'] . "</td><td>  " . $fila['ciP'] . "</td> <td>" . $fila['sexo'] . "</td><td>" . $fila ['condicion'] . " </td><td>" . $fila ['categoriaP']. "</td><td>" . $fila ['idKata']. "</td> </tr>";
}
echo "</table>";
?>
<div id="salir">
<a href="http://127.0.0.1/ProgramaPhp/Participantes.html" id="Volver"> Volver</a>
</div>
</body>
</html>
