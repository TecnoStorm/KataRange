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
            $this->_torneos[]= new Torneo($fila['idTorneo'],$fila['fecha'],$fila['Categoria'],$fila['cantParticipantes'],$fila['estado'],$fila['ParaKarate'],$fila['sexo']);
        }
}

public function guardar($fecha,$categoria,$cantParticipantes,$estado,$paraKarate,$sexo){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        if (!$conexion) {
            die('Error en la conexión: ' . mysqli_connect_error());
        }
        $consulta = $conexion ->prepare(
            "INSERT INTO Torneo (fecha,Categoria,cantParticipantes,estado,paraKarate,sexo)
            values (?,?,?,?,?,?)");
        
        $consulta->bind_param("ssisss", $fecha, $categoria, $cantParticipantes, $estado,$paraKarate,$sexo);
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
echo "<tr> <td> idTorneo </td> <td> Fecha </td> <td> Categoria </td> </td><td> cantParticipantes </td> <td> Estado </td><td> ParaKarate </td> <td> Sexo </td></tr> ";
while($fila = $resultado->fetch_assoc()){
echo "<tr> <td>".$fila['idTorneo'] . " </td><td>" . $fila['fecha'] . "</td><td>  " . $fila['Categoria'] . "</td> <td>" . $fila['cantParticipantes'] . "</td><td>" . $fila ['estado'] ."</td> <td>". $fila['ParaKarate']. "</td><td>". $fila['sexo']. "</td> </tr>";
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
    $sexo="";
    $cantParticipantes=0;
    foreach ($this->_torneos as $torneo){
        if ($torneo->getEstado()=="abierto"){
            $categoria=$torneo->getCategoria();
            $sexo=$torneo->getSexo();
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
        if($participantesArray[$x]->getCondicion()=="Ninguna" && !$paraKarate && $participantesArray[$x]->getCategoria()==$categoria && $participantesArray[$x]->getSexo()==$sexo){
            echo "hola";
            $participantesMismaCategoria[]=$participantesArray[$x];
        }
        if($participantesArray[$x]->getCondicion()!="Ninguna" && $paraKarate && $participantesArray[$x]->getCategoria()==$categoria && $participantesArray[$x]->getSexo()==$sexo){
            $participantesMismaCategoria[]=$participantesArray[$x];
        }
    }
    return $participantesMismaCategoria;
}

public function ParticipantesTorneo($ciP,$idTorneo,$puesto,$cinturon){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    if (!$conexion) {
        die('Error en la conexión: ' . mysqli_connect_error());
    }
    $consulta = $conexion ->prepare(
        "INSERT INTO Compite (ciP,idTorneo,puesto,cinturon)
        values (?,?,?,?)");
    
    $consulta->bind_param("iiss", $ciP,$idTorneo,$puesto,$cinturon);
    $consulta->execute();
    $consulta->close();
    $conexion->close();
}

public function ciParticipantesTorneo(){
    $ciParticipantes=[];
    $consulta = "SELECT * FROM estan ORDER BY notaFinal desc"; 
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $resultado = mysqli_query($conexion, $consulta);
    if (!$conexion) {
        die('Error en la conexión: ' . mysqli_connect_error());
    }

    if (!$resultado){
        die('Error en la consulta SQL: ' . $consulta);
    }

    while($fila = $resultado->fetch_assoc()){
        $ciParticipantes[]=$fila['ciP'];
    }
    var_dump($ciParticipantes);
    return $ciParticipantes;
}
public function ciParticipantesTorneoPools(){
    $ciParticipantes=[];
    $consulta = "SELECT * FROM compite"; 
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $resultado = mysqli_query($conexion, $consulta);
    if (!$conexion) {
        die('Error en la conexión: ' . mysqli_connect_error());
    }

    if (!$resultado){
        die('Error en la consulta SQL: ' . $consulta);
    }

    while($fila = $resultado->fetch_assoc()){
        $ciParticipantes[]=$fila['ciP'];
    }
    var_dump($ciParticipantes);
    return $ciParticipantes;
}
public function Puestos(){
    $puestos=[];
    $existe=false;
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta= "SELECT * FROM compite";
    $resultado = mysqli_query($conexion, $consulta);
    while($fila=$resultado->fetch_assoc()){
        $puestos[]=$fila['puesto'];
    }
    for($x=0;$x<count($puestos);$x++){
        if($puestos[$x]!=0){
            $existe=true;
        }
    }
    return $existe;
}
}
?>