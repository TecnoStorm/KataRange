<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/Juez/RegistrarJueces.css">
    <link rel="stylesheet" href="../CSS/Idioma.css">
    <title>Document</title>
</head>
<section id='contenedorIdioma'>
<p>es</p>
<input type="checkbox" id="idioma">
<p>in</p>
</section>
<body>
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
    <input type="text" name="usuario" placeholder="Usuario" id="usuario" class="TraducirInput"required>
    </section>
    <section class="contenedorInputs">
    <input type="number" name="ci" placeholder="CI" id="ci" min=10000000 class="TraducirInput" max=99999999 required>
    <input type="password" name="clave" placeholder="Contraseña" id="clave" class="TraducirInput" required>
    <input type="password" name="confirmacion" placeholder="Confirmacion" id="confirmacion"class="TraducirInput" required>
    </section>
    <select name="nombreTorneo" id=selectTorneo required>';
    echo "<option selected hidden class='Traducir'>Ingrese categoria</option>";
    foreach($nombresTorneo as $nombre){
           echo "<option value='$nombre'> $nombre </option>";
    }
    echo  '</select>
    <input type="submit" name="registrar" value="REGISTRAR" id="boton" class="TraducirValue">
    </form>
    <p id="mensajeJuez"></p>
</section>'
?>
<a href="../../index.php" class="Traducir"> 
    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
        <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
      </svg>
      Volver</a>
<script src="../../Controlador/js/RegistrarJuez.js"></script>
<script src="../../Controlador/js/traduccion.js"> </script>
</body>
</html>


