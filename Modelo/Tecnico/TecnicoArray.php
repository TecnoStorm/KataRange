<?php
include "Tecnico.php";
require_once ("../../Controlador/config.php");
require_once ("../../Modelo/Juez/JuezArray.php");
class TecnicoArray{
    private $_tecnicos=array();
    public function __construct(){
        $consulta = "SELECT * FROM tecnico";
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $resultado = mysqli_query($conexion, $consulta);
        if (!$conexion) {
            die('Error en la conexión: ' . mysqli_connect_error());
        }
        if (!$resultado){
            die('Error en la consulta SQL: ' . $consulta);
            }
        while($fila = $resultado->fetch_assoc()){
            $this->_tecnicos[]= new Tecnico($fila['nombreTecnico'],$fila['apellido'],$fila['ciT'],$fila['usuario'],$fila['clave']);
        }
    }

    public function comparar($usuario, $clave){
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
            $contraseña='';
            $consulta = $conexion->prepare("SELECT SHA2(?, 256) as clave;");
            $consulta->bind_param("s",$clave);
            $consulta->execute();
            $resultado=$consulta->get_result();
            while($fila = $resultado->fetch_assoc()){
               $contraseña=$fila['clave'];
            }
            $existe=false;
            foreach($this->_tecnicos as $tecnico){
                if($tecnico->getUsuario()==$usuario && $tecnico->getClave()==$contraseña){
                    $existe=true;
                }
            }
            return $existe;
        }

}
?> 