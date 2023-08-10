<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/Juez/RegistrarJuez.css">
    <title>Document</title>
</head>
<body>
<?php
define('SERVIDOR', '127.0.0.1');
define('USUARIO', 'root');
define('PASS', '');
define('BD', 'cuk');

include "JuezArray.php";
$nombre=$_POST["nombre"]; 
$apellido=$_POST["apellido"];
$usuario=$_POST["usuario"];
$ci=$_POST["ci"];
$clave=$_POST["clave"];
$confirmacion=$_POST["confirmacion"];
$juezArray=new JuezArray();
if($clave==$confirmacion){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);

   if (!$conexion) {
       die('Error en la conexión: ' . mysqli_connect_error());
   }
   $consulta = $conexion->prepare(
       "INSERT INTO persona (ci,nombre,apellido)
       values (?,?,?)");
   
   $consulta2 = $conexion->prepare(
    "INSERT INTO Juez (nombre,Apellido,usuario,ciJ,contraseña)
    values (?,?,?,?,?)");
    
    $consulta->bind_param("iss", $ci, $nombre, $apellido);
    $consulta->execute();
    $consulta->close();
    $consulta2->bind_param("sssis", $nombre, $apellido,$usuario,$ci,$clave);
    $consulta2->execute();
    $consulta2->close();
    $conexion->close();
    
    $juezArray->ponerJuez($nombre, $apellido, $ci,$clave);
    $juezArray->guardar();
    echo "<a href='http://127.0.0.1/ProgramaPhp/RegistrarJuez.html'> Volver </a>";
}
else{
    echo " <p id='mensaje'>las contraseñas no coinciden</p>";
    echo "<a href=http://127.0.0.1/ProgramaPhp/RegistrarJuez.html> Volver </a>";
}

?>   
</body>
</html>
