<?php
require_once("Escuela.php");
require_once ("../../Controlador/Config.php");
class EscuelaArray{
    private $_escuelas=array ();
    public function __construct(){
            $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
            $consulta = "SELECT * FROM Escuela";
            $resultado = mysqli_query($conexion, $consulta);
            if (!$resultado){
                die('Error en la consulta SQL: ' . $consulta);
                }
            while($fila = $resultado->fetch_assoc()){
                $escuela= new Escuela($fila['idEscuela'],$fila['Tecnica'],$fila['nombre_Escuela']);
                array_push($this->_escuelas, $escuela);
            }
    }

public function guardar($tecnica, $nombre){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        if (!$conexion) {
            die('Error en la conexión: ' . mysqli_connect_error());
        }
        $consulta = $conexion ->prepare(
            "INSERT INTO Escuela (Tecnica,nombre_Escuela)values (?,?)");
        
        $consulta->bind_param("ss", $tecnica, $nombre);
        $consulta->execute();
        $consulta->close();
        $conexion->close();
} 

public function guardarParticipante($idEscuela, $ci){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        if (!$conexion) {
            die('Error en la conexión: ' . mysqli_connect_error());
        }
        $consulta = $conexion ->prepare(
            "INSERT INTO estudia (idEscuela,ciP)values (?,?)");
        
        $consulta->bind_param("ii", $idEscuela, $ci);
        $consulta->execute();
        $consulta->close();
        $conexion->close();
}  
public function existeEscuela($nombre){
    $existe=false;
    foreach($this->_escuelas as $escuela){
        if($escuela->getNombre()==$nombre){
            $existe=true;
        }
    }
    return $existe;
}
public function infoEscuela($nombre){
    $escuelaEleccion=null;
    foreach($this->_escuelas as $escuela){
        if($escuela->getNombre()==$nombre){
            $escuelaEleccion=$escuela;
        }
    }
    return $escuelaEleccion;
}
public function nombresEscuela(){
    $nombres=[];
    foreach($this->_escuelas as $escuela){
        $nombres[]=$escuela->getNombre();
    }
return $nombres;
}
}
?>