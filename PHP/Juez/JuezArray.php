<?php
require_once("Juez.php");
include "../config.php";
    class JuezArray{
        private $_jueces=array(); 
        public function __construct(){
            $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
            $consulta = "SELECT * FROM Juez";
            $resultado = mysqli_query($conexion, $consulta);
            if (!$resultado){
                die('Error en la consulta SQL: ' . $consulta);
                }
            while($fila = $resultado->fetch_assoc()){
                $juez= new Juez($fila['nombre'],$fila['Apellido'],$fila['usuario'],$fila['ciJ'],$fila['contraseña']);
                array_push($this->_jueces, $juez);
            }
        }

        public function guardar($nombre, $apellido,$usuario,$ci,$contraseña){
            $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
            if (!$conexion) {
                die('Error en la conexión: ' . mysqli_connect_error());
            }
            $consulta = $conexion ->prepare(
                "INSERT INTO Persona (ci,nombre,apellido)
                values (?,?,?)");

            $consulta->bind_param("iss", $ci, $nombre, $apellido);
            $consulta->execute();
            $consulta->close();
            $consulta2 = $conexion ->prepare("INSERT INTO Juez (nombre,Apellido,usuario,ciJ,contraseña) values (?,?,?,?,?)");
            $consulta2->bind_param("sssis", $nombre, $apellido,$usuario,$ci,$contraseña);
            $consulta2->execute();
            $consulta2->close();
            $conexion->close();
        }

        public function ponerJuez($nombre, $apellido,$ci,$clave){  
            $juez= new Juez(PHP_EOL .$nombre, $apellido,$ci,$clave); 
            array_push($this->_jueces,$juez);
        }
        
        public function listar(){
            $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
            $consulta = "SELECT * FROM Juez";
            
            $resultado = mysqli_query($conexion, $consulta);
            
            if (!$resultado){
                die('Error en la consulta SQL: ' . $consulta);
            }
            echo "<table border='2'>";
            echo "<tr> <td> Nombre </td> <td> apellido </td> <td> Ci </td> </td><td> sexo </td> <td> condicion</td> </tr>";
            while($fila = $resultado->fetch_assoc()){
            echo "<tr> <td>".$fila['nombre'] . " </td><td>" . $fila['Apellido'] . "</td><td>  " . $fila['usuario'] . "</td> <td>" . $fila['ciJ'] . "</td><td>" . $fila ['contraseña'] ."</td> </tr>";
            }
            echo "</table>";
        }
        
        public function comparar($usuario, $clave){
            $existe=false;
            foreach($this->_jueces as $juez){
                if($juez->getUsuario()==$usuario && $juez->getClave()==$clave){
                    $existe=true;
                }
            }
            return $existe;
            }
    
    public function obtenerCi($usuario){
        $ciUsuario=0;
        foreach($this->_jueces as $juez){
            if($juez->getusuario()==$usuario){
               $ciUsuario=$juez->getCi();
            }
        }
    return $ciUsuario;
    }
}
?>