<?php
session_start();
?>
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
require_once ("../Modelo/Nota/NotaArray.php");
include "../Modelo/Participante/ParticipanteArray.php";
$notaArray=new NotaArray();
if(isset($_SESSION["participantesPool"])){
    $participantes=unserialize($_SESSION["participantesPool"]);
}
if($participantes->cantParticipantes()==4){
    if($notaArray->cantNotas()<4){
        echo "<p>no se ingresaron todas las notas</p>";
        echo "<section class='salir'>";
        echo "<a href='Juez/OpcionesJuez.php' id='Volver'> volver </a>";
        echo "</section>";
    }

}
if($participantes->cantParticipantes()>=10){
    if($notaArray->cantNotas()<$participantes->cantParticipantes()){
       
        echo "<p>no se ingresaron todas las notas</p>";
        echo "<section class='salir'>";
        echo "<a href='Juez/OpcionesJuez.php' id='Volver'> volver </a>";
        echo "</section>";
    }
    else{        
        $pool=$_POST["pool"];
        $notaArray->ordenar();      
        echo "<section id='ganadores'>";
        $participantes->ganadoresDeRonda($pool);
        echo "</section>";
        echo "<section class='salir'>";
        echo "<a href='Juez/OpcionesJuez.php' id='Volver'> volver </a>";
        echo "</section>";
        }        
    }
?>  
</body>
</html>
