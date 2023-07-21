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
$nombre=$_POST['nombre'];
$ci=$_POST['ci'];
$apellido=$_POST["apellido"];
$categoria=$_POST['categoria'];
$sexo=$_POST['sexo'];
$idKata=$_POST['idKata'];
$pull="null";
$nota="null";
$_participantes=new ParticipanteArray();
$participante= new Participante($nombre, $apellido,$ci,$sexo,$categoria,$idKata,$pull,$nota);
$_participantes->ponerParticipante($nombre, $apellido, $ci, $sexo, $categoria, $idKata,$pull,$nota);
$_participantes->guardar();
echo "<a href='http://127.0.0.1/ProgramaPhp/Participantes.html'>Volver</a>"
?>
</body>
</html>



