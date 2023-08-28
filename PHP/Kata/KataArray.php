<?php
require_once("Kata.php");
require_once ("C:/xampp/htdocs/ProgramaPhp/PHP/config.php");
class KataArray{
    private $_katas;

    public function __construct(){
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
        $this->_katas[]= new Kata($fila['ciP'],$fila['idkata'],$fila['ronda']);
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

}
?>