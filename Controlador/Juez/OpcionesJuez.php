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
$existe=$juezArray->comparar($usuario, $clave);

if($existe){
    echo "<p id='oculto'>Inicio de sesión exitoso<p>";
    $_SESSION["usuario"]=$usuario;
    $_SESSION["clave"]=$clave;
    echo "<section id='contenedor'>";
    echo "<h1 class='Traducir'> Opciones de Juez</h1>";
    echo "<form action='MostrarJueces.html' method'post'>";
    echo "<input type='submit' name='mostrar' value='Mostrar jueces' class='TraducirValue'>";
    echo "</form>";
    echo "<h2 class='Traducir'>Puntuar participante</h2>
    <a href='../Nota/NotaKata.html'> Puntaje</a>";
    
}
else{
   echo "Usuario o contraseñas incorrectos";
}
?>


