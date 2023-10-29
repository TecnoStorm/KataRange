<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../CSS/Kata/AsignarKata.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
require_once ("../../Modelo/Torneo/TorneoArray.php");
require_once ("../../Modelo/Kata/KataArray.php");
require_once ("../../Modelo/Participante/ParticipanteArray.php");
$torneos= new TorneoArray();
$katas= new KataArray();
$participantes=new ParticipanteArray();
$nombreTorneo=$_POST['nombreTorneo'];
$torneo=$torneos->infoTorneo($nombreTorneo);
echo "<h1> Participantes por asignar Kata </h2>";
$cis=$katas->ciSinAsignar($torneo->getIdTorneo());
if(count($cis)==0){
    echo "<h2> Todos los participantes ya tienen un kata asignado </h2>";
}
else{
    $katas->listarSinAsignar($torneo->getIdTorneo());
    echo "<form id='formularioAsignar'>";
    echo "<section>";
    echo "<input type='number' min='1' max='102' placeholder='Numero' name='idKata'>";
    echo "<select name='ciParticipante'>
    <option selected hidden class='Traducir'>Ingrese participante</option>";
    for ($x = 0; $x < count($cis); $x++) {
        $participante=$participantes->devolverInfo($cis[$x]);
        echo "nombre: ". $nombre;
        echo "<option value='" . $cis[$x] . "'>" . $participante->getNombre() . "</option>";
    }
    echo "</select>";
    echo "</section>";
    echo "<input type='hidden' name='idTorneo' value=".$torneo->getIdTorneo().">";
    echo "<input type='submit' value='Cambiar'>";
    echo "</form>";
    echo "<p id='mensajeAsignar'> </p>";
    echo "<script src='../../Controlador/js/AsignarKata.js'> </script>";
}
    ?>
    <section id="salir">
<a href='../../index.php' class="Traducir"> 
   <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' fill='currentColor' class='bi bi-box-arrow-left' viewBox='0 0 16 16'>
       <path fill-rule='evenodd' d='M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z'/>
       <path fill-rule='evenodd' d='M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z'/>
     </svg>
     Volver</a>
</section>
</body>
</html>


