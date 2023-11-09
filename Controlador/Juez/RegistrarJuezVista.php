
    <?php
    require_once("../../Modelo/Torneo/TorneoArray.php");
    $torneos=new TorneoArray();
    $nombresTorneo=$torneos->nombresTorneo();
    echo '<section id="contenedor">
    <h1 class="Traducir">Registarse</h1>
    
    <form id="formularioJuez">
    <section class="contenedorInputs">
    <input type="text" name="nombre" placeholder="Nombre" id="nombre " class="TraducirInput"required>
    <input type="text" name="apellido" placeholder="Apellido" id="apellido" class="TraducirInput"required>
    </section>
    <section class="contenedorInputs">
    <input type="text" name="usuario" placeholder="Usuario" id="usuario" class="TraducirInput"required>
    <input type="number" name="ci" placeholder="CI" id="ci" min=10000000 class="TraducirInput" max=99999999 required>
    </section>
    <section class="contenedorInputs">
    <input type="password" name="clave" placeholder="Contraseña" id="clave" class="TraducirInput" required>
    <input type="password" name="confirmacion" placeholder="Confirmacion" id="confirmacion"class="TraducirInput" required>
    </section>
    <select name="nombreTorneo" id=selectTorneo required>';
    echo "<option selected hidden class='Traducir' required>Ingrese torneo</option>";
    foreach($nombresTorneo as $nombre){
           echo "<option value='$nombre'> $nombre </option>";
    }
    echo  '</select>
    <p id="mensajeJuez"></p>
    <input type="submit" name="registrar" value="REGISTRAR" id="boton" class="TraducirValue">
    </form>

</section>'
?>



