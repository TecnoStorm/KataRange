<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/Torneo/Torneo.css">
    <link rel="stylesheet" href="../../Vista/CSS/Idioma.css">
    <title>Document</title>
</head>
<body>
    <section id='contenedorIdioma'>
        <p>es</p>
        <input type="checkbox" id="idioma">
        <p>en</p>
        </section>
    <section id="contenedorTotal">
        <section class="formularioGestion">
    <h1 class="Traducir">Gestión De Torneos</h1>
    <form id="formularioTorneo">
    <input type="date" name="fecha" id="fecha" required>
    <select name="categoria" id="categoria" required>
    <option value="none" class="Traducir" selected disabled hidden>Seleccione categoria</option>
    <option value="12/13">12/13</option>
    <option value="14/15">14/15</option>
    <option value="16/17">16/17</option>
    <option value="mayores" class="Traducir">Mayores</option>
    </select>
    <select name="paraKarate" id="paraKarate" required>
    <option value="none" selected disabled hidden>Para-karate</option>
    <option value="si" class="Traducir"> Si</option>
    <option value="no"> No</option>
    </select>
</section>
    <input type="number" name="cantidad" max="96" placeholder="Cantidad de Participantes" id="cantidad" class="TraducirInput" required>
    <select name="sexo" id="sexo" required>
        <option value="none" class="Traducir" selected disabled hidden>Seleccione sexo</option>
        <option value="Femenino" class="Traducir" >Femenino</option>;
        <option value="Masculino" class="Traducir" >Masculino</option>;
        </select>
    <input type="text" name="nombre" placeholder="Nombre del torneo" class="TraducirInput" required>
    <input type="text" name="direccion" placeholder="Direccion" class="TraducirInput" required>
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
    <input type="submit" value="Crear torneo" id="crearTorneo" class="TraducirValue" required>
    </form>
    <section class="formularios">
    <a href="MostrarTorneo.php" class="Traducir"> Mostrar Torneos</a>
    <p id="mensajeTorneo"></p>
    <p id="mensajeEditarTorneo"></p>
</section>
    <h2 class="Traducir">Abir/cerrar Torneo</h2>
    <form id="modificarTorneo">
    <section class="abrir-torneo">
    <input type="number" name="id" placeholder="Id del torneo" id="id">     
    <select name="estado" id="estado">
    <option value="none" class="Traducir" selected disabled hidden>Seleccione estado</option>
    <option value="abierto" class="Traducir">Abierto</option>
    <option value="cerrado" class="Traducir">Cerrado</option>
    </select>
    </section>
    <input type="submit" value="Modificar" id="Modificar" class="TraducirValue">    
    </form>
    <h2 class="Traducir"> Crear Evento </h2>
    <form id="CrearEvento">
    <input type="text" name="nombreEvento" placeholder="nombreEvento" id="nombreEvento">
    <input type="submit" value="Asignar" id="asignar" class="TraducirValue">
    </form>
    <p id="mensajeCrearEvento"></p>
</section>
<section class="salir">
<a href="../Tecnico/opcionesTecnico.php" class="Traducir"> 
    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
        <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
      </svg>
      Volver</a>
    </section>
<script src="../../Controlador/js/CrearTorneo.js"></script>
<script src="../../Controlador/js/ModificarTorneo.js"></script>
<script src="../../Controlador/js/CrearEvento.js"></script>
<script src="../../Controlador/js/traduccion.js"> </script>
</body>
</html>