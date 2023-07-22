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
require_once("Nota/NotaArray.php");
if(isset($_SESSION["ci"]) && isset($_SESSION["nota"])){
    $ci=$_SESSION["ci"];
    $nota=$_SESSION["nota"];
    $participanteArray = new ParticipanteArray();
    $notaArray=new NotaArray();
    $existe = $participanteArray->comparar($ci);  
}
else{
    $ci = $_POST["ci"];
    $nota = $_POST["puntaje"];
    $participanteArray = new ParticipanteArray();
    $notaArray=new NotaArray();
    $existe = $participanteArray->comparar($ci);  
}   
if(isset($_SESSION["notaFinal"])){
    echo "reiniciando puntajes";
    session_destroy();
}
else{


if ($existe) {
    if (isset($_SESSION["participantes"][$ci])) {
        $notas = $_SESSION["participantes"][$ci]["notas"];
        if (count($_SESSION["participantes"][$ci]["notas"]) == 4) {
        echo "<div class='notas'>";
        echo "<a href='Puntaje.php'> Enviar notas </a>";
        echo "</div>";
        $_SESSION["ci"]=$ci;
        $_SESSION["nota"]=$nota;
        }
        if (count($_SESSION["participantes"][$ci]["notas"]) == 5) {
            $mayorPuntaje = array_search(max($notas), $notas);
            $menorPuntaje = array_search(min($notas), $notas);
            unset($notas[$mayorPuntaje]);
            unset($notas[$menorPuntaje]);
            $notaFinal = array_sum($notas);
            echo $ci;
            $participanteArray->cambioNota($ci,$notaFinal);
            $participanteArray->guardar();
            echo "<div class='notas'>";
            echo $notaFinal;
            var_dump($notas);
            echo "</div>";
            $_SESSION["ci"]=$ci;
            $_SESSION["notaFinal"]=$notaFinal;
            $nombre=$participanteArray->obtenerNombre($ci);
            $apellido=$participanteArray->obtenerApellido($ci);
            $notaArray->ponerNota($ci,$nombre,$apellido,$notaFinal);
            echo $nombre. $apellido;
            $notaArray->guardar();
            echo "<form action='informacion.php' method='post'>";
echo "<input type='hidden' name='ci' value='$ci'>";
echo "<input type='submit' name='enviar' value='Mostrar información del participante'>"; 
echo "</form>"; 
        } else {
            $notas[] = $nota; 
            $_SESSION["participantes"][$ci]["notas"] = $notas;
            echo "<div class='notas'>";
            var_dump($notas);
            echo "</div>";
        }
    } else {
        $_SESSION["participantes"][$ci] = array("notas" => array($nota));
        var_dump($_SESSION["participantes"][$ci]["notas"]);
    }
} else {
    echo "Participante no registrado";
}
}
?>  
</body>
</html>
