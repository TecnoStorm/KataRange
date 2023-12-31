<?php
require_once ("Torneo.php");
require_once (__DIR__."/../../Controlador/config.php");
require_once (__DIR__."/../Participante/ParticipanteArray.php");
class TorneoArray{
private $_torneos= array();
public function __construct(){
    $consulta = "SELECT * FROM torneo";
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
public function guardar($fecha,$categoria,$cantParticipantes,$estado,$paraKarate,$sexo,$nombre,$direccion,$nombreEvento){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        if (!$conexion) {
            die('Error en la conexión: ' . mysqli_connect_error());
        }
        $consulta = $conexion ->prepare("INSERT INTO Torneo (fecha,Categoria,cantParticipantes,estado,paraKarate,sexo,nombre,direccion)
        values (?,?,?,?,?,?,?,?)");
        $consulta2 =$conexion ->prepare("INSERT INTO contiene (idTorneo,idEvento) values (?,?)");
        $consulta->bind_param("ssisssss", $fecha, $categoria, $cantParticipantes, $estado,$paraKarate,$sexo,$nombre,$direccion);
        $consulta->execute();
        $consulta->close();
        $torneo=$this->infoTorneo($nombre);
        $idTorneo=$torneo->getIdTorneo();
        echo "id Torneo: ". $idTorneo;
        $idEvento=$this->idEvento($nombreEvento);
        $consulta2->bind_param("ii",$idTorneo,$idEvento);
        $consulta2->execute();
        $conexion->close();
        echo "<p style='color:green'> torneo creado con exito</p>";
}

public function mostrar(){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = "SELECT * FROM torneo";
    $resultado = mysqli_query($conexion, $consulta);
    if (!$resultado){
        die('Error en la consulta SQL: ' . $consulta);
    }
    echo "<table class='torneos'><thead>";
    echo "<tr> <th class='Traducir'> Id del torneo </th> <th class='Traducir'> Fecha </th> <th class='Traducir'> Categoria </th> <th class='Traducir'> Cantidad de participantes </th> <th class='Traducir'> Estado </th><th> ParaKarate </th> <th class='Traducir'> Sexo </th><th class='Traducir'> Nombre  </th> <th class='Traducir'> Direccion </th></tr></thead><tbody>";
    while($fila = $resultado->fetch_assoc()){
        echo "<tr> <td>".$fila['idTorneo'] . " </td><td>" . $fila['fecha'] . "</td><td class='Traducir'>  " . $fila['Categoria'] . "</td> <td>" . $fila['cantParticipantes'] . "</td><td class='Traducir'>" . $fila ['estado'] ."</td> <td class='Traducir'>". $fila['ParaKarate']. "</td><td class='Traducir'>". $fila['sexo']. "</td><td>". $fila['nombre']."</td> <td>" . $fila['direccion']. "</td> </tr>";
    }
    echo "</tbody></table>";
}

public  function cambiarEstado($id,$estado){
    $existe=$this->existeTorneo($id);
    if($existe){
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $consulta = $conexion ->prepare(
            "UPDATE torneo SET estado = ? WHERE idTorneo=?;");
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
    for($x=0;$x<$cantParticipantes;$x++){
        if($participantesArray[$x]->getCondicion()=="Ninguna" && !$paraKarate && $participantesArray[$x]->getCategoria()==$categoria && $participantesArray[$x]->getSexo()==$sexo){
            
            $participantesMismaCategoria[]=$participantesArray[$x];
        }
        if($participantesArray[$x]->getCondicion()!="Ninguna" && $paraKarate && $participantesArray[$x]->getCategoria()==$categoria && $participantesArray[$x]->getSexo()==$sexo){
            $participantesMismaCategoria[]=$participantesArray[$x];
        }
    }
    return $participantesMismaCategoria;
}

public function ParticipantesTorneo($ciP,$idTorneo){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    if (!$conexion) {
        die('Error en la conexión: ' . mysqli_connect_error());
    }
    $consulta = $conexion ->prepare("INSERT INTO compite (ciP,idTorneo) values (?,?)");
    
    $consulta->bind_param("ii", $ciP,$idTorneo);

    $success=$consulta->execute();
        if(!$success){
       echo $consulta->error;
    }
    $consulta->close();
    $conexion->close();
}

public function ciParticipantesTorneo($idTorneo){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $ciParticipantes=[];
    $consulta = $conexion->prepare("SELECT estan.* FROM estan join tiene on estan.idP=tiene.idP where idT=? ORDER BY idP;"); 
    $consulta->bind_param("i",$idTorneo);
    $consulta->execute();
    $resultado = $consulta->get_Result();
    while($fila = $resultado->fetch_assoc()){
        $ciParticipantes[]=$fila['ciP'];
    }
    return $ciParticipantes;
}
public function idEscuelasTorneo($idTorneo){
    $idEscuelas=[];
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = $conexion->prepare("select idEscuela from compite join estudia on compite.ciP=estudia.ciP  where idTorneo=? group by idEscuela order by idEscuela ;"); 
    $consulta->bind_param("i",$idTorneo);
    $consulta->execute();
    $resultado = $consulta->get_Result();
    while($fila = $resultado->fetch_assoc()){
        $idEscuelas[]=$fila['idEscuela'];
    }
    return $idEscuelas;
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
        if(in_array("3ro",$puestos)){
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
    $consulta = "SELECT * FROM torneo";
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
public function mismaCategoriaInsectionidual($nombreTorneo,$sexoP,$condicion,$categoriaP){
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
    }
    return $puedeParticipar;
}

public function infoTorneo($nombre){
    $torneoEleccion;
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = "select  * from torneo";
    $resultado = mysqli_query($conexion, $consulta);
    while($fila = $resultado->fetch_assoc()){
        if($nombre==$fila['nombre']){
            $torneoEleccion=new torneo($fila['idTorneo'],$fila['fecha'],$fila['Categoria'],$fila['cantParticipantes'],$fila['estado'],$fila['ParaKarate'],$fila['sexo'],$fila['nombre'],$fila['direccion']);
        }
        }
 return $torneoEleccion;
}

public function CrearEvento($nombre){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = $conexion->prepare("Insert into evento (nombreEvento) values (?) ");
    $consulta->bind_param("s",$nombre);
    $success=$consulta->execute();
    if(!$success){
        $consulta->close();
        return false;
    }
    else{
        $consulta->close();
        return true;
    }
}
public function nombresEvento(){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = "select  * from evento";
    $resultado = mysqli_query($conexion, $consulta);
    $nombres=[];
        if (!$conexion) {
            die('Error en la conexión: ' . mysqli_connect_error());
        }
        if (!$resultado){
            die('Error en la consulta SQL: ' . $consulta);
            }
        while($fila = $resultado->fetch_assoc()){
        $nombres[]=$fila['nombreEvento'];
        }
return $nombres;
}
public function idEvento($nombre){
    $id;
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = "select  * from evento";
    $resultado = mysqli_query($conexion, $consulta);
    while($fila = $resultado->fetch_assoc()){
        if($nombre==$fila['nombreEvento']){
            $id=$fila['idEvento'];
        }
        }
 return $id;
}

public function nombreUsado($nombre){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $existe=false;
    $consulta= "SELECT * FROM torneo";
    $resultado = mysqli_query($conexion, $consulta);
    while($fila = $resultado->fetch_assoc()){
        if($nombre==$fila['nombre']){
            $existe=true;
        }
    }
    return $existe;
}
} 
?> 