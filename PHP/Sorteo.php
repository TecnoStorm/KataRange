<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/Sorteo.css">
    <title>Document</title>
</head>
<body>
<?php
include "Participante/ParticipanteArray.php";
require_once ("C:/xampp/htdocs/ProgramaPhp/PHP/Nota/NotaArray.php");
$participantes= new ParticipanteArray();
$notas=new NotaArray();
echo "<div class='contenedor'>";
$participantes->pull();
$participantes->mostrarPull();
if($participantes->cantParticipantes()==3){
    
    echo "<a href='Ganadores.php'> Ganadores </a>";
    echo "</div>";
}
    
if($participantes->cantParticipantes()==4){
    echo "<div class='contenedor'>";
    echo "<a href='llaves.php'> mostrar siguientes llaves </a>";
    echo "</div>";
}
if($participantes->cantParticipantes()>10){
    $cantPool=$participantes->cantPools();
    echo "<div class='contenedor'>";
    $participantes->ordenarParticipante();
    $participantes->guardar();
    echo "<form action='Llaves.php' method='post'>";
    echo "<input type='number' name='pool' PlaceHolder='Ingresar pool' max=$cantPool>";
    echo "<input type='submit' name='enviar' value='ver ganadores'>";
    echo "</form>";
}
?>  
</body>
</html>

