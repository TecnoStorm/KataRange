
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
    echo "<section id='contenedorTabla'>";
    $katas->listarSinAsignar($torneo->getIdTorneo());
    echo "</section>";
    echo "<form id='formularioAsignar'>";
    echo "<section id='contenedorKata'>";
    echo "<input type='number' min='1' max='102' placeholder='Numero' name='idKata'>";
    echo "<select name='ciParticipante' id='ciParticipante'>
    <option selected hidden class='Traducir' value='0'>Ingrese participante</option>";
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
}
    ?>

