<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/Llaves.css">
    <title>Document</title>
</head>
<body>
<?php
session_start();
require_once ("C:/xampp/htdocs/ProgramaPhp/PHP/Nota/NotaArray.php");
include "Participante/ParticipanteArray.php";
$notaArray=new NotaArray();
if(isset($_SESSION["participantesPool"])){
    $participantes=unserialize($_SESSION["participantesPool"]);
}
if($participantes->cantParticipantes()==4){
    if($notaArray->cantNotas()<4){
        echo "<p>no se ingresaron todas las notas</p>";
        echo "<div class='salir'>";
        echo "<a href='Juez/OpcionesJuez.php' id='Volver'> volver </a>";
        echo "</div>";
    }

}
if($participantes->cantParticipantes()>=10){
    if($notaArray->cantNotas()<$participantes->cantParticipantes()){
       
        echo "<p>no se ingresaron todas las notas</p>";
        echo "<div class='salir'>";
        echo "<a href='Juez/OpcionesJuez.php' id='Volver'> volver </a>";
        echo "</div>";
    }
    else{        
        $pool=$_POST["pool"];
        $notaArray->ordenar();      
        echo "<div id='ganadores'>";
        $participantes->ganadoresDeRonda($pool);
        echo "</div>";
        echo "<div class='salir'>";
        echo "<a href='Juez/OpcionesJuez.php' id='Volver'> volver </a>";
        echo "</div>";
        }        
    }
?>  
</body>
</html>
