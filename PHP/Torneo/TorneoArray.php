<?php
require_once ("Torneo.php");
require_once ("C:/xampp/htdocs/ProgramaPhp/PHP/config.php");
require_once ("C:/xampp/htdocs/ProgramaPhp/PHP/Participante/ParticipanteArray.php");
class TorneoArray{
private $_torneos= array();
public function __construct(){
    $consulta = "SELECT * FROM Torneo";
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $resultado = mysqli_query($conexion, $consulta);
        if (!$conexion) {
            die('Error en la conexión: ' . mysqli_connect_error());
        }
        if (!$resultado){
            die('Error en la consulta SQL: ' . $consulta);
            }
        while($fila = $resultado->fetch_assoc()){
        $this->_torneos[]= new Torneo($fila['idTorneo'],$fila['fecha'],$fila['Categoria'],$fila['cantParticipantes'],$fila['estado'],$fila['ParaKarate']);
 
}
}

public function guardar($fecha,$categoria,$cantParticipantes,$estado,$paraKarate){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        if (!$conexion) {
            die('Error en la conexión: ' . mysqli_connect_error());
        }
        $consulta = $conexion ->prepare(
            "INSERT INTO Torneo (fecha,Categoria,cantParticipantes,estado,paraKarate)
            values (?,?,?,?,?)");
        
        $consulta->bind_param("ssiss", $fecha, $categoria, $cantParticipantes, $estado,$paraKarate);
        $consulta->execute();
        $consulta->close();
        $conexion->close();
}

public function mostrar(){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = "SELECT * FROM Torneo";
    $resultado = mysqli_query($conexion, $consulta);
    if (!$resultado){
    die('Error en la consulta SQL: ' . $consulta);
    }
echo "<table border='2'>";
echo "<tr> <td> idTorneo </td> <td> Fecha </td> <td> Categoria </td> </td><td> cantParticipantes </td> <td> Estado </td><td> ParaKarate </td></tr> ";
while($fila = $resultado->fetch_assoc()){
echo "<tr> <td>".$fila['idTorneo'] . " </td><td>" . $fila['fecha'] . "</td><td>  " . $fila['Categoria'] . "</td> <td>" . $fila['cantParticipantes'] . "</td><td>" . $fila ['estado'] ."</td> <td>". $fila['ParaKarate']. "</td></tr>";
}
echo "</table>";
}

public  function cambiarEstado($id,$estado){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = $conexion ->prepare(
        "UPDATE Torneo SET estado = ? WHERE idTorneo=?;");
            $consulta->bind_param("si", $estado,$id);
            $consulta->execute();
            $consulta->close();
            $conexion->close();
}
public function abierto(){
    $abierto=false;
    foreach($this->_torneos as $torneo){
        if($torneo->getEstado()=="abierto"){
         $abierto=true;
        }
    }
    return $abierto;
}

public function mismaCategoria(){
    $categoria="";
    $parakarate=false;
    $cantParticipantes=0;
    foreach ($this->_torneos as $torneo){
    if ($torneo->getEstado()=="abierto"){
        $categoria=$torneo->getCategoria();
        if($torneo->getParaKarate()=="si"){
        $paraKarate=true;
        }
    }
}
$participantes=new ParticipanteArray();
$participantesArray=$participantes->getParticipantes();
$cantParticipantes=$participantes->cantParticipantes();
$participantesMismaCategoria=[];
echo $categoria;
for($x=0;$x<$cantParticipantes;$x++){
    if($participantesArray[$x]->getCondicion()=="Ninguna" && !$paraKarate && $participantesArray[$x]->getCategoria()==$categoria){
        echo "hola";
        $participantesMismaCategoria[]=$participantesArray[$x];
}
    
        if($participantesArray[$x]->getCondicion()!="Ninguna" && $paraKarate && $participantesArray[$x]->getCategoria()==$categoria){
            $participantesMismaCategoria[]=$participantesArray[$x];
    }
}
return $participantesMismaCategoria;
}

}

?>