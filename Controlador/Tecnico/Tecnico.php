<?php
session_start();

if(isset($_SESSION['nombreTorneo'])){
    unset($_SESSION['nombreTorneo']);
}
require_once ("../../Modelo/Tecnico/TecnicoArray.php");
require_once ('../../Modelo/Torneo/TorneoArray.php');

if(isset($_SESSION['nombreTorneo'])){
    unset($_SESSION['nombreTorneo']);
}
require_once ("../../Modelo/Tecnico/TecnicoArray.php");
require_once ('../../Modelo/Torneo/TorneoArray.php');
if(isset($_SESSION["clave"]) && isset($_SESSION["usuario"])){
    $usuario=$_SESSION['usuario'];
    $clave=$_SESSION['clave'];
}
else{
    $usuario=$_POST['usuario'];
    $clave=$_POST['clave']; 
}
$torneos= new TorneoArray();
$mismaCategoria=$torneos->mismaCategoria();
foreach($mismaCategoria as $participante){
    $nombresParticipantes[]=$participante->getNombre();
    $cedulas[]=$participante->getCi();
}
$tecnicos=new TecnicoArray();
$existe=$tecnicos->comparar($usuario, $clave);
if($existe){
    echo "<p id='oculto'>Inicio de sesión exitoso<p>";
    $_SESSION["usuario"]=$usuario;
    $_SESSION["clave"]=$clave;
    echo "<section id='contenedor'>";
    echo "<h1> Opciones Tecnico </h1>";   
    echo "<h2> Ingresar Participante </h2>" ;
    echo   " <a href='../../Vista/Participante/FormularioParticipantes.html' id='texto2' class='Traducir'> Ingresar</a>";
    echo "<h2>Registrar juez</h2>";
    echo  " <a href='../../Vista/Juez/RegistrarJuez.html' id='texto4' class='Traducir'> Registrar</a>";
    echo "<h2 class='Traducir'>Mostrar pools</h2>
    <form id='formularioPool'>";
    $nombres=$torneos->nombresTorneo();
    echo  "<select name='nombreTorneo'>
    <option selected class='Traducir' hidden>Ingrese torneo</option>";
    foreach($nombres as $nombre){
    echo "<option value='$nombre'> $nombre </option>";
    }
    echo"</select>
    <input type='submit' value='pools'></input>
    </form>";
    echo "<h2 class='Traducir'>Asignar Kata</h2>";   
    echo "<form id = 'formularioKata'><section class='contenedor-kata'>";
    echo  "<select name='nombreTorneo'>
    <option selected class='Traducir' hidden>Ingrese torneo</option>";
    foreach($nombres as $nombre){
        echo "<option value='$nombre'> $nombre </option>";
        }
        echo"</select>";
    echo "<input type='submit' value='mostrar'>
    </section></form>";
    echo "<h2 class='Traducir'>Tanteador</h2>";
    echo "<form id='formularioTanteador'>";
    echo  "<select name='nombreTorneo'>
    <option selected class='Traducir' hidden>Ingrese participante</option>";
    foreach($nombres as $nombre){
    echo "<option value='$nombre'> $nombre </option>";
    }
    echo "<input type='submit' value='Elegir' class='TraducirValue'>";
    echo "</form>
    <h2 class='Traducir'>Gestionar torneos</h2>
    <section class='boton-gestion'>";
    echo "<a href='../Torneo/Torneos.html' class='Traducir'> Gestión de Torneos</a>
    </section>
    </section>
    </section>";
    echo "<section id='salir'>
    <a href='../../index.html' class='Traducir'> 
        <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' fill='currentColor' class='bi bi-box-arrow-left' viewBox='0 0 16 16'>
            <path fill-rule='evenodd' d='M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z'/>
            <path fill-rule='evenodd' d='M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z'/>
        </svg>
        Volver
    </a>
</section>";
}
else{
    echo "Usuario o contraseñas incorrectos". $usuario . $clave;
} 
?>