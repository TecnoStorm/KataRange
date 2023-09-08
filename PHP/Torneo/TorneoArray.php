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
            $this->_torneos[]= new Torneo($fila['idTorneo'],$fila['fecha'],$fila['Categoria'],$fila['cantParticipantes'],$fila['estado'],$fila['ParaKarate'],$fila['sexo'],$fila['nombre'],$fila['direccion']);
        }
}
public function guardar($fecha,$categoria,$cantParticipantes,$estado,$paraKarate,$sexo,$nombre,$direccion){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        if (!$conexion) {
            die('Error en la conexión: ' . mysqli_connect_error());
        }
        $consulta = $conexion ->prepare(
            "INSERT INTO Torneo (fecha,Categoria,cantParticipantes,estado,paraKarate,sexo,nombre,direccion)
            values (?,?,?,?,?,?,?,?)");
        
        $consulta->bind_param("ssisssss", $fecha, $categoria, $cantParticipantes, $estado,$paraKarate,$sexo,$nombre,$direccion);
        $consulta->execute();
        $consulta->close();
        $conexion->close();
        echo "<p style='color:green'> torneo creado con exito</p>";
}

public function mostrar(){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = "SELECT * FROM Torneo";
    $resultado = mysqli_query($conexion, $consulta);
    if (!$resultado){
    die('Error en la consulta SQL: ' . $consulta);
    }
echo "<table border='2' class='torneos'>";
echo "<tr> <td> idTorneo </td> <td> Fecha </td> <td> Categoria </td> </td><td> cantParticipantes </td> <td> Estado </td><td> ParaKarate </td> <td> Sexo </td><td> Nombre  </td> <td> direccion </td></tr>";
while($fila = $resultado->fetch_assoc()){
echo "<tr> <td>".$fila['idTorneo'] . " </td><td>" . $fila['fecha'] . "</td><td>  " . $fila['Categoria'] . "</td> <td>" . $fila['cantParticipantes'] . "</td><td>" . $fila ['estado'] ."</td> <td>". $fila['ParaKarate']. "</td><td>". $fila['sexo']. "</td><td>". $fila['nombre']."</td> <td>" . $fila['direccion']. "</td> </tr>";
}
echo "</table>";
}

public  function cambiarEstado($id,$estado){
    $existe=$this->existeTorneo($id);
    if($existe){
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $consulta = $conexion ->prepare(
            "UPDATE Torneo SET estado = ? WHERE idTorneo=?;");
                $consulta->bind_param("si", $estado,$id);
                $consulta->execute();
                $consulta->close();
                $conexion->close();        
    }    
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
    $paraKarate=false;
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
    return $ciParticipantes;
}
public function ciParticipantesTorneoPools($idTorneo){
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
        if($fila['idTorneo']==$idTorneo)
        $ciParticipantes[]=$fila['ciP'];
    }
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
        if(in_array(3,$puestos)){
            $existe=true;
        }
    }
    return $existe;
}
public function mismoEstado($estado,$id){
    $existeTorneo=$this->existeTorneo($id);
    if($existeTorneo){
        $existe=false;
        foreach($this->_torneos as $torneo){
            if($torneo->getIdTorneo()==$id && $torneo->getEstado()==$estado){
                   $existe=true;
            }
        }
    return $existe;
    }
}
public function existeTorneo($id){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $existe=false;
    $ids=[];
    $consulta = "SELECT * FROM Torneo";
    $resultado = mysqli_query($conexion, $consulta);
    if (!$resultado){
    die('Error en la consulta SQL: ' . $consulta);
    }
while($fila = $resultado->fetch_assoc()){
 $ids[]=$fila['idTorneo'];
}
for($x=0;$x<count($ids);$x++){
    if($id==$ids[$x]){
        $existe=true;
    }
}
return $existe;
}

public function participantesAsignados($id){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $existe=false;
    $ids=[];
    $consulta = "SELECT * FROM compite";
    $resultado = mysqli_query($conexion, $consulta);
    if (!$resultado){
    die('Error en la consulta SQL: ' . $consulta);
    }
while($fila = $resultado->fetch_assoc()){
 $ids[]=$fila['idTorneo'];
}
for($x=0;$x<count($ids);$x++){
    if($id==$ids[$x]){
        $existe=true;
    }
}
return $existe;
}
public function nombresTorneo(){
    $nombres=[];
    foreach($this->_torneos as $torneo){
        $nombres[]=$torneo->getNombre();
    }
 return $nombres;
}
public function mismaCategoriaIndividual($nombreTorneo,$sexoP,$condicion,$categoriaP){
    $categoria="";
    $sexo="";
    $cantParticipantes=0;
    $puedeParticipar=false;
    foreach ($this->_torneos as $torneo){
        if ($torneo->getNombre()==$nombreTorneo){
            $categoria=$torneo->getCategoria();
            $sexo=$torneo->getSexo();
        }
    }
    $torneo=$this->infoTorneo($nombreTorneo);
    $participantes=new ParticipanteArray();
    if($categoria==$categoriaP && $sexo==$sexoP && $torneo->getParaKarate()=="si" && $condicion!="Ninguna" ||$categoria==$categoriaP && $sexo==$sexoP && $torneo->getParaKarate()=="no" && $condicion=="Ninguna"  ){
       $puedeParticipar=true;
       echo "HOLAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA";
    }
   echo $categoria .$categoriaP . $sexo. $sexoP. $torneo->getParaKarate().$condicion; 
    return $puedeParticipar;
}

public function infoTorneo($nombre){
    $torneoEleccion;
    foreach($this->_torneos as $torneo){
        if($torneo->getNombre()==$nombre){
            $torneoEleccion=$torneo;
        }
    }
 return $torneoEleccion;
}
} 
?> 