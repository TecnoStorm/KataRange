
    <?php
    require_once("../../Modelo/Torneo/TorneoArray.php");
    $torneos=new TorneoArray();
    $nombres=$torneos->nombresEvento();
    echo "<select name='nombreEvento'required>
    <option selected class='Traducir' hidden>Ingrese Evento</option>";
    foreach($nombres as $nombre){
        echo "<option value='$nombre'> $nombre </option>";
    }
 echo "</select>";
    ?>
    