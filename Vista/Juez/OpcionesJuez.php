<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/Juez/OpcionesJueces.css">
    <title>Document</title>
</head>
<body>
<?php
session_start();
include '../../Modelo/Juez/JuezArray.php';
require_once ('../../Modelo/Torneo/TorneoArray.php');
if(isset($_SESSION["clave"]) && isset($_SESSION["usuario"])){
    $usuario=$_SESSION['usuario'];
    $clave=$_SESSION['clave'];
}
else{
    $usuario=$_POST['usuario'];
    $clave=$_POST['clave']; 
}

$juezArray= new JuezArray();
$torneos=new TorneoArray();
$mismaCategoria=$torneos->mismaCategoria();
$nombres=[];
$cedulas=[];
foreach($mismaCategoria as $participante){
    $nombres[]=$participante->getNombre();
    $cedulas[]=$participante->getCi();
}
$existe=$juezArray->comparar($usuario, $clave);

if($existe){
    echo "<p id='oculto'>Inicio de sesión exitoso<p>";
    echo "<div id='contenedor'>";
    echo "<h1> Opciones de Juez</h1>";
    echo "<form action='MostrarJueces.php' method'post'>";
    echo "<input type='submit' name='mostrar' value='Mostrar jueces'>";
    echo "</form>";
    echo "<h2>Puntuar participante</h2>
    <a href='../Nota/NotaKata.php'> Puntaje</a>";
    echo "<h2>Mostrar pools</h2>
    <a href='../Pool/CreadorPools.php'> Pools </a>";
    echo "</form>";
    echo "<h2>Tanteador</h2>";
    echo "<form action='../Participante/Tanteador.php' method='post'>";
    echo "<select name='ciParticipante'>";
    for($x=0;$x<count($nombres);$x++){
      echo "<option value='$cedulas[$x]'> $nombres[$x] </option>";
    }
    echo "<input type='submit' value='Mostrar'>";
    echo "</form>
    <h2>Gestionar torneos</h2>
    <section class='boton-gestion'>";
    echo "<a href='../Torneo/Torneos.html'> Gestión de Torneos</a>
    </section>
    </div>";
    $_SESSION["usuario"]=$usuario;
    $_SESSION["clave"]=$clave;
}
else{
   echo "Usuario o contraseñas incorrectos ayuda";
}
?>
<div id="salir">
<a href='../../index.php'> 
   <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' fill='currentColor' class='bi bi-box-arrow-left' viewBox='0 0 16 16'>
       <path fill-rule='evenodd' d='M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z'/>
       <path fill-rule='evenodd' d='M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z'/>
     </svg>
     Volver</a>

</div>
</body>
</html>

