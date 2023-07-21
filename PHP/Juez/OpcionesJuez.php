<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/Juez/OpcionesJueces.css">
    <title>Document</title>
</head>
<body>
<?php
session_start();
include 'JuezArray.php';
if(isset($_SESSION["clave"]) && isset($_SESSION["usuario"])){
    $usuario=$_SESSION["usuario"];
    $clave=$_SESSION["clave"];
}
else{
    $usuario=$_POST['usuario'];
    $clave=$_POST['clave'];
}
$juezArray= new JuezArray();
$existe=$juezArray->comparar($usuario, $clave);
if($existe){
    echo "<div id='contenedor'>";
    echo "<h1> Opciones de Juez</h1>";
    echo "<form action='MostrarJueces.php' method'post'>";
    echo "<input type='submit' name='mostrar' value='mostrar Jueces'>";
    echo "</form>";
    echo "<a href='../Nota/NotaKata.php'> Puntaje</a>";
    echo "<a href='../Sorteo.php'> Sorteo </a>";
    echo "</form>";
    echo "</div>";
    $_SESSION["usuario"]=$usuario;
    $_SESSION["clave"]=$clave;
}
else{
    echo "usuario o clave incorrectos";
}
?>
<a href="../Index.php?borrar=true" id="Volver"> Volver </a>
</body>
</html>

