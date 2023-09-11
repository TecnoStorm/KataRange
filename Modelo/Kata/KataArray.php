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
}
?>