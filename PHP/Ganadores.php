<?php
include "ParticipanteArray.php";
require_once ("NotaArray.php");
$notaArray=new NotaArray();
$participantes=new ParticipanteArray();
if($participantes->cantParticipantes() ==3){
    if($notaArray->cantNotas()<3){
        echo "no se ingresaron todas las notas";
    }
    else{
        echo "<table border='1'>";
        echo "<tr><td>Nombre </td> <td> apellido </td><td> nota Final </td> </tr> ";
        $notaArray->ordenar();
        $posicion=$notaArray->posicionGanador();
        $notaArray->guardar();
        $notaArray->listar();
        echo "</table>";
        $notaArray->ganador($posicion);
    }
}
if($participantes->cantParticipantes()==4){
   if($notaArray->cantNotas()<4){
    echo "no se ingresaron todas las notas";
      }
    else{
        echo "<table border='1'>";
        echo "<tr><td>Nombre </td> <td> apellido </td><td> nota Final </td> </tr> ";
        $notaArray->ordenar();
        $posicion=$notaArray->posicionGanador();
        $notaArray->guardar();
        $notaArray->listar();
        echo "</table>";
        $notaArray->ganador($posicion);
    }




}


?>