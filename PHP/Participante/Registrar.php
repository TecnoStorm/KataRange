<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/Participante/Registrar.css">
    <title>Document</title>
</head>
<body>
<?php
include "ParticipanteArray.php";
require_once ("C:/xampp/htdocs/ProgramaPhp/PHP/Kata/KataArray.php");
$nombre=$_POST['nombre'];
$ci=$_POST['ci'];
$apellido=$_POST["apellido"];
$categoria=$_POST['categoria'];
$sexo=$_POST['sexo'];
$idKata=$_POST['idKata'];
$condicion=$_POST["Condicion"];
$katas=new KataArray();
$_participantes=new ParticipanteArray();
$_participantes->guardar($nombre, $apellido,$ci,$sexo,$condicion,$categoria);
$katas->guardarKata($ci,$idKata);
echo "<div id='salir'>";
echo "<a href='http://127.0.0.1/ProgramaPhp/Participantes.html'>Volver</a>"; 
echo "</div>";
?>
</body>
</html>



