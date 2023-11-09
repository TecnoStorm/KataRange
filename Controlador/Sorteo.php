<?php
session_start();
?>
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
include "../Modelo/Participante/ParticipanteArray.php";
require_once ("../Modelo/Nota/NotaArray.php");
$participantes= new ParticipanteArray();
$notas=new NotaArray();
echo "<section class='contenedor'>";
$participantes->pool();
echo "<section id='pool'>";
$participantes->mostrarPool();
echo "</section>";

if($participantes->cantParticipantes()==3){
    
    echo "<a href='Ganadores.php'> Ganadores </a>";
    echo "</section>";
}
    
if($participantes->cantParticipantes()==4){
    echo "<section class='contenedor'>";
    echo "<a href='llaves.php'> mostrar siguientes llaves </a>";
    echo "</section>";
}
if($participantes->cantParticipantes()>=10){
    $_SESSION["participantesPool"]=serialize($participantes);
    $cantPool=$participantes->cantPools();
    echo "<section class='contenedor'>";
    echo "<form action='Llaves.php' method='post'>";
    echo "<input type='number' name='pool' PlaceHolder='Ingresar pool' max=$cantPool>";
    echo "<input type='submit' name='enviar' value='ver ganadores'>";
    echo "</form>";
}
?>  
</body>
</html>

