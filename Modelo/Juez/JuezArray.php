<?php
require_once("Juez.php");
require_once (__DIR__."/../../Controlador/config.php");
    class JuezArray{
        private $_jueces=array(); 
        public function __construct(){
            $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
            $consulta = "SELECT * FROM juez";
            $resultado = mysqli_query($conexion, $consulta);
            if (!$resultado){
                die('Error en la consulta SQL: ' . $consulta);
                }
            while($fila = $resultado->fetch_assoc()){
                $juez= new Juez($fila['nombre'],$fila['Apellido'],$fila['usuario'],$fila['ciJ'],$fila['clave']);
                array_push($this->_jueces, $juez);
            }
        }

        public function guardar($nombre, $apellido,$usuario,$ci,$contraseña,$idTorneo){
            $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
            if (!$conexion) {
                die('Error en la conexión: ' . mysqli_connect_error());
            }
            $consulta = $conexion ->prepare("INSERT INTO persona (ci,nombre,apellido) values (?,?,?)");
            $consulta->bind_param("iss", $ci, $nombre, $apellido);
            $consulta->execute();
            $consulta->close();
            $consulta2 = $conexion ->prepare("INSERT INTO juez (nombre,Apellido,usuario,ciJ,clave) values (?,?,?,?,SHA2(?, 256))");
            $consulta3= $conexion->prepare("INSERT INTO juzga (ciJ,idTorneo) values (?,?)");
            $consulta2->bind_param("sssis", $nombre, $apellido,$usuario,$ci,$contraseña);
            $success=$consulta2->execute();
            $consulta3->bind_param("ii", $ci,$idTorneo);
            $consulta3->execute();
            if(!$success){
                echo "<p style='color: #EDAD14; font-size: 25px;'> juez ya registrado";
            }
            else{
                $consulta2->close();
                $conexion->close();
                echo "<p style='color: green;font-size: 25px'> Judge entered correctly </p>";
            }
            
        }

        public function ponerJuez($nombre, $apellido,$ci,$clave){  
            $juez= new Juez(PHP_EOL .$nombre, $apellido,$ci,$clave); 
            array_push($this->_jueces,$juez);
        }
        
        public function listar(){
            $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
            $consulta = "SELECT * FROM juez";
            
            $resultado = mysqli_query($conexion, $consulta);
            
            if (!$resultado){
                die('Error en la consulta SQL: ' . $consulta);
            }
            echo "<table>";
            echo "<thead> <tr> <th class='Traducir'> Nombre </th> <th class='Traducir'> apellido </th><th> ci </th> </tr></thead><tbody>";
            while($fila = $resultado->fetch_assoc()){
                echo "<tr> <td>".$fila['nombre'] . " </td><td>" . $fila['Apellido'] . "</td><td>" . $fila['ciJ'] . "</td></tr>";
            }
            echo "</tbody></table>";
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
            foreach($this->_jueces as $juez){
                if($juez->getUsuario()==$usuario && $juez->getClave()==$contraseña){
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
    public function obtenerIdTorneo($ci){
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
            $consulta = "SELECT * FROM juzga";
            
            $resultado = mysqli_query($conexion, $consulta);
            
            if (!$resultado){
                die('Error en la consulta SQL: ' . $consulta);
            }
            while($fila = $resultado->fetch_assoc()){
                if($fila["ciJ"] == $ci){
                    return $fila["idTorneo"];
                }
            }
        
    }

public function usuarioValido($usuario){
    foreach ($this->_jueces as $juez){
        if($usuario==$juez->getUsuario()){
            return true;
        }
    }
    return false;
}
public function idTorneoJuez($ci){
    $idTorneo=0;
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta ="Select * from juzga";
    $resultado = mysqli_query($conexion, $consulta);
    while($fila = $resultado->fetch_assoc()){
        if($ci==$fila['ciJ']){
          $idTorneo=$fila['idTorneo'];
        }
    }
return $idTorneo;
}
public function fechaHora($ciP,$ciJ,$idP){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = $conexion->prepare("update puntua set fecha=CURDATE(),hora=now() where ciP=? and ciJ=? and idP=?");
    $consulta->bind_param("iii",$ciP,$ciJ,$idP);
    $consulta->execute();
    $consulta->close();
}
}
?>