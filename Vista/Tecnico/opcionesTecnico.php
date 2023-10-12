<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../Vista/CSS/Juez/OpcionesJueces.css">
    <link rel="stylesheet" href="../../Vista/CSS/Idioma.css">
</head>
<body>
<?php
session_start();
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
    echo   " <a href='../../Vista/Participante/FormularioParticipantes.php' id='texto2' class='Traducir'> Ingresar</a>";
    echo "<h2>Registrar juez</h2>";
    echo  " <a href='../../Vista/Juez/RegistrarJuez.php' id='texto4' class='Traducir'> Registrar</a>";
    echo "<h2 class='Traducir'>Mostrar pools</h2>
    <form action='../../Vista/Pool/CreadorPools.php' method='post' id='formularioPool'>";
    $nombres=$torneos->nombresTorneo();
    echo  "<select name='nombreTorneo'>";
    foreach($nombres as $nombre){
    echo "<option value='$nombre'> $nombre </option>";
    }
    echo"</select>
    <input type='submit' value='pools'></input>
    </form>";
    echo "<h2 class='Traducir'>Asignar Kata</h2>";
    echo "<form action='AsignarKata.php' method='post'>";
    echo  "<select name='nombreTorneo'>";
    foreach($nombres as $nombre){
        echo "<option value='$nombre'> $nombre </option>";
        }
        echo"</select>";
    echo "<input type='submit' value='mostrar'>
    </form>";
    echo "<h2 class='Traducir'>Tanteador</h2>";
    echo "<form action='../Participante/Tanteador.php' method='post' id='FormularioTanteador'>";
    echo "<select name='ciParticipante'>";
    for($x=0;$x<count($nombres);$x++){
      echo "<option value='$cedulas[$x]'> $nombresParticipantes[$x] </option>";
    }
    echo "</select>";
    echo "<input type='submit' value='Mostrar' class='TraducirValue'>";
    echo "</form>
    <h2 class='Traducir'>Gestionar torneos</h2>
    <section class='boton-gestion'>";
    echo "<a href='../Torneo/Torneos.php' class='Traducir'> Gestión de Torneos</a>
    </section>
    </section>
    </div>";
}
else{
    echo "Usuario o contraseñas incorrectos";
} 
?>
<div id="salir">
<a href='../../index.php' class="Traducir"> 
   <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' fill='currentColor' class='bi bi-box-arrow-left' viewBox='0 0 16 16'>
       <path fill-rule='evenodd' d='M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z'/>
       <path fill-rule='evenodd' d='M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z'/>
     </svg>
     Volver</a>
</div>
</body>
</html>