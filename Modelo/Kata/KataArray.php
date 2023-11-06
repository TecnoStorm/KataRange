<?php
require_once("Kata.php");
require_once ("../../Controlador/config.php");
class KataArray{
    private $_katas;

    public function __construct(){
        $consulta = "SELECT * FROM kata";
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $resultado = mysqli_query($conexion, $consulta);
        if (!$conexion) {
            die('Error en la conexión: ' . mysqli_connect_error());
        }
        if (!$resultado){
            die('Error en la consulta SQL: ' . $consulta);
            }
        while($fila = $resultado->fetch_assoc()){
        $this->_katas[]= new Kata($fila['idKata'],$fila['nombre']);
    } 
}
    public function guardarKata($ciP,$idKata){
        $ronda=1;
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $consulta = $conexion ->prepare("INSERT INTO utiliza2 (ciP,idkata,ronda) values (?,?,?)");
        $consulta->bind_param("iii", $ciP, $idKata, $ronda);
        $success=$consulta->execute();
        $consulta->close();
        $conexion->close();
    }

public function devolverInfo($ci){
    $valores=[];
    $consulta = "SELECT * FROM utiliza2";
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $resultado = mysqli_query($conexion, $consulta);
    if (!$conexion) {
        die('Error en la conexión: ' . mysqli_connect_error());
    }
    if (!$resultado){
        die('Error en la consulta SQL: ' . $consulta);
        }
    while($fila = $resultado->fetch_assoc()){
        if($fila['ciP']==$ci){
            $valores[0]=$fila['idkata'];
            $valores[1]=$fila['ronda'];
        }
    }
return $valores;
}   
public function devolverNombre($idKata){
    foreach($this->_katas as $kata){
    
    if($idKata==$kata->getIdKata()){
        return $kata->getNombre();
    }
   }
}
public function sinAsignarKata($idTorneo){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = $conexion->prepare("Select * from utiliza2 join compite on utiliza2.ciP=compite.ciP where idTorneo=?");
    $consulta->bind_param("i",$idTorneo);
    $consulta->execute();
    $resultado=$consulta->get_result();
    while ($fila = $resultado->fetch_assoc()){
        if($fila['idkata']==0){
            return true;
        }
    }
return false;
}

public function listarSinAsignar($idTorneo){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = $conexion->prepare("SELECT utiliza2.ciP, utiliza2.ronda ,concat(participante.nombreP,' ',participante.apellidoP) 'Nombre Completo' FROM utiliza2 join compite on utiliza2.ciP=compite.ciP join participante on compite.ciP=participante.ciP where idTorneo=? and utiliza2.idKata=0;");
    $consulta->bind_param("i",$idTorneo);
    $consulta->execute();
    $resultado= $consulta->get_result();
    echo "<section class='contenedor-tabla'><table border='1'>
    <section class='contenedor-thead'><thead><tr> <th> CI Participante </th> <th> Ronda </th> <th> Nombre Completo </th></tr></thead></section><tbody>";
    while ($fila = $resultado->fetch_assoc()){
    echo "<tr><td>".$fila['ciP']. "</td><td>". $fila['ronda']."</td><td>". $fila['Nombre Completo'] . "</td></tr>"; 
    }
echo "</tbody></table></section>";
}
public function AsignarKata($idKata,$ci){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = $conexion->prepare("update utiliza2 set idkata=? where ciP=? ");
    $consulta ->bind_param("ii",$idKata,$ci);
    $success=$consulta->execute();
    if(!$success){
        echo "<p style='color:red'> error en la consulta </p>" . $consulta->error;
    }
    else{
        echo "<p style='color:green'> Kata asignado correctamente </p>";
    }
}
public function ciSinAsignar($idTorneo){
    $ciP=[];
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = $conexion->prepare("SELECT participante.ciP FROM utiliza2 join compite on utiliza2.ciP=compite.ciP join participante on compite.ciP=participante.ciP where idTorneo=? and utiliza2.idKata=0;");
    $consulta->bind_param("i",$idTorneo);
    $consulta->execute();
    $resultado= $consulta->get_result();
    while ($fila = $resultado->fetch_assoc()){
     $ciP[]=$fila['ciP'];
    }
    return $ciP;
}
public function katasUtilizados($ci,$idTorneo,$numero){
    $katasUtilizados=[];
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = $conexion->prepare("select idKata from utiliza2 join tiene on utiliza2.idP=tiene.idP where idT=? and utiliza2.ciP=?;");
    $consulta ->bind_param("ii",$idTorneo,$ci);
    $consulta->execute();
    $resultado = $consulta->get_result();
    while ($fila = $resultado->fetch_assoc()){
     $katasUtilizados[]=$fila['idKata'];
    }
if(in_array($numero,$katasUtilizados)){
    return true;
}
else{
    return false;
}
}
}
?>