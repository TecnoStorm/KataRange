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
include "JuezArray.php";
$nombre=$_POST["nombre"]; 
$apellido=$_POST["apellido"];
$ci=$_POST["ci"];
$clave=$_POST["clave"];
$confirmacion=$_POST["confirmacion"];
$juezArray=new JuezArray();
if($clave==$confirmacion){
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
