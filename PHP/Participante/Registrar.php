<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/Participante/Registrar.css">
    <title>Document</title>
</head>
<body>
<?php
 define('SERVIDOR', '127.0.0.1');
 define('USUARIO', 'root');
 define('PASS', '');
 define('BD', 'cuk');
 
 $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);

    if (!$conexion) {
        die('Error en la conexión: ' . mysqli_connect_error());
    }
    $consulta = $conexion ->prepare(
        "INSERT INTO Persona (ci,nombre,apellido)
        values (?,?,?)");
    
    $consulta2 = $conexion ->prepare(
     "INSERT INTO Participante (nombreP,apellidoP,ciP,sexo,condicion,categoriaP,idKata)
     values (?,?,?,?,?,?,?)");

include "ParticipanteArray.php";
$nombre=$_POST['nombre'];
$ci=$_POST['ci'];
$apellido=$_POST["apellido"];
$categoria=$_POST['categoria'];
$sexo=$_POST['sexo'];
$idKata=$_POST['idKata'];
$pool="null";
$nota="null";
$condicion=$_POST["Condicion"];
$_participantes=new ParticipanteArray();
$participante= new Participante($nombre, $apellido,$ci,$sexo,$categoria,$idKata,$pool,$nota);
$_participantes->ponerParticipante($nombre, $apellido, $ci, $sexo, $categoria, $idKata,$pool,$nota);
$_participantes->guardar();
echo "<div id='salir'>";
echo "<a href='http://127.0.0.1/ProgramaPhp/Participantes.html'>Volver</a>"; 
echo "</div>";
$consulta->bind_param("iss", $ci, $nombre, $apellido);
    $consulta->execute();
    $consulta->close();
    $consulta2->bind_param("ssisssi", $nombre, $apellido,$ci,$sexo,$condicion,$categoria,$idKata);
    $consulta2->execute();
    $consulta2->close();
    $conexion->close();
?>
</body>
</html>



