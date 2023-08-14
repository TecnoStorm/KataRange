<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/Puntaje.css">
    <title>Document</title>
</head>
<body>
<?php
session_start();
include "Participante/ParticipanteArray.php";
include "Juez/JuezArray.php";
if(isset($_SESSION["usuario"])){
    $usuario=$_SESSION["usuario"];
}
$participantes= new ParticipanteArray();
$jueces=new JuezArray();
$ciJ=$jueces->obtenerCi($usuario);
$ciP=$_POST["ci"];
$idP=$participantes->obtenerPool($ciP);
$nota=$_POST['puntaje'];
$participantes->notas($ciJ,$ciP,$idP,$nota);
$participantes->notaFinal($ciP);
?>  
</body>
</html>
