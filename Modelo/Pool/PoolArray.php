<?php
require_once ("Pool.php");
require_once (__DIR__."/../Participante/ParticipanteArray.php");
require_once (__DIR__."/../Torneo/TorneoArray.php");
    class PoolArray{
    private $_pools=array();

    public function __construct(){
        $consulta = "SELECT * FROM pool";
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $resultado = mysqli_query($conexion, $consulta);
        if (!$conexion) {
            die('Error en la conexión: ' . mysqli_connect_error());
        }
        if (!$resultado){
            die('Error en la consulta SQL: ' . $consulta);
        }
        while($fila = $resultado->fetch_assoc()){
            $this->_pools[]= new Pool($fila['estado'],$fila['hora_inicio'],$fila['idP'],$fila['hora_final'],$fila['numero']);
        }
    }

    public function CrearPool($idTorneo,$cantParticipantes){
        $participantes=new ParticipanteArray();
        echo $cantParticipantes;
        $arrayParticipantes= (array) $participantes->devolverArray();
        $uno=1;
        $mayorPool=$this->MayorId($idTorneo);
        echo "mayor pool: ".$mayorPool;
        $estado="cerrado";
        $horaInicio="null";
        $horaFinal="null";
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        if (!$conexion) {
            die('Error en la conexión: ' . mysqli_connect_error());
        }
        $consulta = $conexion ->prepare("INSERT INTO pool (estado,hora_inicio,hora_final,numero) values (?,?,?,?)");

        $idsPool=[];
        $consulta3 = $conexion ->prepare("INSERT INTO tiene (idP,idT) values (?,?)");
        if($cantParticipantes==3){
            $consulta->bind_param("sssi", $estado, $horaInicio,$horaFinal,$uno);
            $success=$consulta->execute();
            if(!$success){
                echo "cantidad de participantes: ".$cantParticipantes . $consulta->error;
            }
            $consulta->close(); 
        }
        if($cantParticipantes==4){
          for($x=1;$x<=3;$x++){
            $consulta->bind_param("sssi", $estado, $horaInicio,$horaFinal,$x);
            $consulta->execute();
          }
        }
        if($cantParticipantes==5){
            for($x=1;$x<=4;$x++){
              $consulta->bind_param("sssi", $estado, $horaInicio,$horaFinal,$x);
              $consulta->execute();
        
            }
          }
          if($cantParticipantes>5 && $cantParticipantes<=10){
            for($x=1;$x<=5;$x++){
              $consulta->bind_param("sssi", $estado, $horaInicio,$horaFinal,$x);
              $consulta->execute();
            }
          }
          if($cantParticipantes>10 && $cantParticipantes<=24){
            for($x=1;$x<=7;$x++){
              $consulta->bind_param("sssi", $estado, $horaInicio,$horaFinal,$x);
              $consulta->execute();
            }
          }
          if($cantParticipantes>24 && $cantParticipantes <=48){
            for($x=1;$x<=11;$x++){
              $consulta->bind_param("sssi", $estado, $horaInicio,$horaFinal,$x);
              $consulta->execute();
            }
          }
          if($cantParticipantes>49 && $cantParticipantes <=96){
            for($x=1;$x<=19;$x++){
             
              $consulta->bind_param("ssis", $estado, $horaInicio,$horaFinal,$x);
              $consulta->execute();
            }
          }  
          $consulta2 = "SELECT * FROM pool";
            $resultado = mysqli_query($conexion, $consulta2);
            while($fila = $resultado->fetch_assoc()){
                if($fila['idP']>$mayorPool){
                    $idsPool[]=$fila['idP'];
                }
            }   
                for($x=0;$x<count($idsPool);$x++){
                    $consulta3->bind_param("ii",$idsPool[$x],$idTorneo);
                    $consulta3->execute();
                }
        }

    public function Listar($idTorneo){
        $ids=$this->idPTiene($idTorneo);
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $consulta = $conexion->prepare("SELECT * FROM pool where idP=?");
        echo "<table border='2'><thead>";
        echo "<tr> <th class='Traducir'> Estado </th> <th class='Traducir'> Hora inicio </th> <th> Id pool </th> </th><th class='Traducir'> Hora cierre </th> </tr></thead><tbody> ";
        for($x=0;$x<count($ids);$x++){
            $consulta->bind_param("i",$ids[$x]);
            $consulta->execute();
            $resultado = $consulta->get_result();
            if (!$resultado){
                die('Error en la consulta SQL: ' . $consulta);
            }
            while($fila = $resultado->fetch_assoc()){
                echo "<tr> <td class='Traducir'>".$fila['estado']. " </td><td>" . $fila['hora_inicio'] . "</td><td>  " . $fila['idP'] . "</td> <td>" . $fila['hora_final']. "</td> </tr>";
            }
        }
        echo "</tbody></table>"; 
    }
    
    public function EditarPool($id,$estado,$idTorneo){ 
        $existePool=$this->existePool($id,$idTorneo);    
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $consulta = $conexion ->prepare(
            "update pool join tiene on pool.idP=tiene.idP set estado=? where idT=9  and pool.idP=?");
            $consulta2 = $conexion ->prepare(
                "UPDATE pool join tiene on pool.idP=tiene.idP SET hora_inicio = NOW()  WHERE pool.idP=? and idT=?;"); 
                $consulta3 = $conexion ->prepare(
                    "UPDATE pool SET hora_final = NOW()  WHERE idP=?;"); 
            if($estado=="abierto"){
                $consulta->bind_param("si", $estado,$id,$idTorneo);
                $consulta->execute();
                $consulta->close();
                $consulta2->bind_param("i", $id,$idTorneo);
                $consulta2->execute();
                $consulta2->close();
            }
            else{
                $consulta->bind_param("si", $estado,$id,$idTorneo);
                $consulta->execute();
                $consulta->close();
                $consulta3->bind_param("i", $id,$idTorneo);
                $consulta3->execute();
                $consulta3->close();
            }
            $conexion->close();
    }
    
    public function MostrarAsignados($idTorneo){
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $consulta = $conexion->prepare("SELECT estan.ciP as 'Ci participante',Concat(participante.nombreP, ' ',participante.apellidoP) as nombre,pool.numero as pool,compite.cinturon as Cinturon from estan join compite on estan.ciP=compite.ciP join pool on estan.idP=pool.idP join participante on estan.ciP=participante.ciP where compite.idTorneo=?;");
        $consulta->bind_param("i",$idTorneo);
        $consulta->execute();
        $resultado = $consulta->get_result();
        echo "<table border='1'><thead> 
        <tr> <th> CI Participante </th> <th> Nombre </th> <th> Pool </th> <th> Cinturón </th> </tr></thead><tbody>"; 
        while($fila = $resultado->fetch_assoc()){
            echo "<tr> <td>".$fila['Ci participante']. " </td><td>" . $fila['nombre']. "</td><td>". $fila['pool'] . "</td><td>". $fila['Cinturon']."</td></tr>";
        }
        echo "</tbody></table>";
    }

    public function AsignarPool($idTorneo){
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $torneos=new TorneoArray();
        $participantesMismaCategoria=$torneos->mismaCategoria();
         $idEscuelas=$torneos->idEscuelasTorneo($idTorneo);
         $ciParticipantes=$this->mismaEscuela($idEscuelas,$idTorneo);
         $participantes=new ParticipanteArray();
        $participantesArray=$participantes->devolverArray();
        $ids=$this->RangoPools($idTorneo);
        $idsTiene=$this->idPTiene($idTorneo);
        $id=0;
        $uno=1;
        $cero=0;
        $notaFinal=0;
        $clasificados="null";
        if (count($ciParticipantes) < 3) {
            echo "el torneo se realizará a partir de 3 participantes";
        }
        
        if (count($ciParticipantes) == 3) {
            $cero=0;
            $uno=1;
            $consulta = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
            $consulta2= $conexion->prepare("UPDATE compite set cinturon='Aka' where ciP=?");
            $consulta3= $conexion->prepare("INSERT INTO utiliza2(ciP,idkata,ronda,idP) values (?,?,?,?)");

            for($x=0;$x<count($ciParticipantes);$x++){
                $consulta->bind_param("iiis", $ciParticipantes[$x],$idsTiene[0],$notaFinal,$clasificados);
                $success=$consulta->execute();
                $consulta3->bind_param("iiii",$ciParticipantes[$x],$cero,$uno,$idsTiene[0]);
                $consulta3->execute();
                if(!$success){
                    echo $consulta->error;
                }
                $consulta2->bind_param("i",$ciParticipantes[$x]);
                $consulta2->execute();
                
            }
            $consulta->close();
            $consulta2->close();
            $conexion->close();

        } elseif (count($ciParticipantes) == 4) {
            $consulta = $conexion->prepare("INSERT INTO  estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
            $cinturon="Aka";
            $consulta2=$conexion->prepare("Update compite set cinturon=? where ciP=?");
            $consulta3=$conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda,idP) values (?,?,?,?)");
            for($x=0;$x<count($ciParticipantes);$x++){
                if($x%2!=0){
                    $id=1;
                    $cinturon="Ao";
                }
                else{
                    $id=0;
                    $cinturon="Aka";
                }
                $consulta->bind_param("iiis", $ciParticipantes[$x],$ids[$id],$notaFinal,$clasificados); 
                $consulta->execute();
                $consulta2->bind_param("si",$cinturon,$ciParticipantes[$x]);
                $consulta2->execute();
                $consulta3->bind_param("iiii",$ciParticipantes[$x],$cero,$uno,$ids[$id]);
                $consulta3->execute();
                
            }
           $consulta->close();
           $consulta2->close();
        } elseif (count($ciParticipantes) == 5) {
            $cinturon="Aka";
            $consulta = $conexion ->prepare("INSERT INTO  estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
            $consulta2=$conexion->prepare("Update compite set cinturon=? where ciP=?");
            $consulta3=$conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda,idP) values (?,?,?,?)");    
                        for($x=0;$x<count($ciParticipantes);$x++){
                            if($x%2!=0){
                                $id=1;
                                $cinturon="Ao";       
                                }
                                else{
                                    $id=0;
                                    $cinturon="Aka";    
                                }  
                            $consulta->bind_param("iiis", $ciParticipantes[$x],$ids[$id],$notaFinal,$clasificados); 
                            $consulta->execute();
                            $consulta3->bind_param("iiii",$ciParticipantes[$x],$cero,$uno,$ids[$id]);
                            $consulta3->execute();
                            $consulta2->bind_param("si",$cinturon,$ciParticipantes[$x]);
                            $consulta2->execute();                
                            }     
    } elseif (count($ciParticipantes) > 5 && count($ciParticipantes) <= 10) {
            $consulta = $conexion ->prepare("INSERT INTO  estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
            $consulta2=$conexion->prepare("Update compite set cinturon=? where ciP=?");
            $consulta3=$conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda,idP) values (?,?,?,?)");
            $cinturon="Aka";
            for($x=0;$x<count($ciParticipantes);$x++){
                if($x%2!=0){
                    $id=1;
                    $cinturon="Ao";       
                    }
                    else{
                        $id=0;
                        $cinturon="Aka";    
                    }  
            $consulta->bind_param("iiis", $ciParticipantes[$x],$ids[$id],$notaFinal,$clasificados); 
            $consulta->execute();
            $consulta3->bind_param("iiii",$ciParticipantes[$x],$cero,$uno,$ids[$id]);
            $consulta3->execute();
            $consulta2->bind_param("si",$cinturon,$ciParticipantes[$x]);    
            $consulta2->execute();
            }

        } elseif (count($ciParticipantes) > 10 && count($ciParticipantes)<=24) {
            $consulta = $conexion ->prepare("INSERT INTO estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
            $consulta2=$conexion->prepare("Update compite set cinturon=? where ciP=?");
            $consulta3=$conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda,idP) values (?,?,?,?)");
            $pool1=count($ciParticipantes)/2;
            $uno=1;
            $dos=2;
            for($x=1;$x<=count($ciParticipantes);$x++){ 
                if(($x-1)%2!=0){
                    $cinturon="Ao";
                    $consulta->bind_param("iiis", $ciParticipantes[$x-1],$idsTiene[6],$notaFinal,$clasificados);
                    $consulta->execute();
                    $consulta2->bind_param("si",$cinturon,$ciParticipantes[$x-1]);
                    $consulta2->execute();
                    $consulta3->bind_param("iiii",$ciParticipantes[$x-1],$cero,$uno,$idsTiene[6]);
                    $consulta3->execute();
                }
                else{
                    $cinturon="Aka";
                    $consulta->bind_param("iiis", $ciParticipantes[$x-1],$idsTiene[5],$notaFinal,$clasificados); 
                    $consulta->execute();
                    $consulta2->bind_param("si",$cinturon,$ciParticipantes[$x-1]);
                    $consulta2->execute();
                    $consulta3->bind_param("iiii",$ciParticipantes[$x-1],$cero,$uno,$idsTiene[5]);
                    $consulta3->execute();
                }
            }
            $consulta->close();
        } elseif (count($ciParticipantes) > 24 && count($ciParticipantes)<49){ 
            $consulta = $conexion ->prepare("INSERT INTO estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
            $consulta2=$conexion->prepare("Update compite set cinturon=? where ciP=?");
            $consulta3=$conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda,idP) values (?,?,?,?)");
            $cantpool=count($ciParticipantes)/4-1; 
            $contador=0;
            $pool=1;
            $cinturon="Ao";
            $posicion=10;
            for($x=0;$x<=count($ciParticipantes);$x++){ 
                if($contador>$cantpool && $pool!=4){
                    $pool++;
                    $contador=0;
                    $posicion--;
                }
                if($x>count($ciParticipantes)/2){
                    $cinturon="Aka";       
                }
                $consulta->bind_param("iiii",$ciParticipantes[$x-1],$idsTiene[$posicion],$notaFinal,$clasificados);
                $consulta3->bind_param("iiii",$ciParticipantes[$x-1],$cero,$uno,$idsTiene[$posicion]);
                $consulta3->execute();
                $success=$consulta->execute();
                if(!$success){
                    echo $consulta->error;
                }
                $consulta2->bind_param("si",$cinturon,$ciParticipantes[$x-1]);
                $consulta2->execute();
                $contador++;
            }
            $consulta->close(); 

        } elseif (count($ciParticipantes) > 48 && count($ciParticipantes)<97){
            $consulta = $conexion ->prepare("INSERT INTO estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
            $consulta2=$conexion->prepare("Update compite set cinturon=? where ciP=?");
            $consulta3=$conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda,idP) values (?,?,?,?)");
            $posicionId=18;
            $i=0;
            $uno=1;
            $idKata=0;
            $cinturon="";
            
            for($x=count($ciParticipantes);$x>0;$x--){ 
                $consulta->bind_param("iiii",$ciParticipantes[$i],$idsTiene[$posicionId],$notaFinal,$clasificados);
                $consulta->execute();
                if($i%2!=0){
                    $cinturon="Ao";       
                    }
                    else{
                        $cinturon="Aka";    
                    }
                $consulta2->bind_param("si",$cinturon,$ciParticipantes[$i]);
                $consulta2->execute();
                $consulta3->bind_param("iiii",$ciParticipantes[$i],$idKata,$uno,$idsTiene[$posicionId]);
                $consulta3->execute();
                $posicionId--;
                $i++;
                if($posicionId==10){
                    $posicionId=18;
                }
        }
    }
}

    public function cantPools($idTorneo){
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $consulta = $conexion->prepare("select idP from tiene where idT=?;");
        $consulta->bind_param("i",$idTorneo);
        $consulta->execute();
        $resultado= $consulta->get_result();
        while($fila = $resultado->fetch_assoc()){
            $cantPools[]=$fila['idP'];
        }
        return count($cantPools);
    } 
public function cantRondas($idTorneo){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);    
    $rondas=[];
    $consulta= $conexion->prepare("select utiliza2.* from utiliza2 join compite on utiliza2.ciP=compite.ciP where idTorneo=? order by ronda DESC");
    $consulta->bind_param("i",$idTorneo);
    $consulta->execute();
    $resultado = $consulta->get_result();
    while($fila = $resultado->fetch_assoc()){
    $rondas[]=$fila['ronda'];
}
return $rondas[0];
} 
public function idsPool(){
    $ids=[];
    foreach($this->_pools as $pool){
        $ids[]=$pool->getIdP();
    }
    return $ids;
}

public function idsEstan(){
    $ids=[];
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);    
    $consulta="SELECT * FROM estan";
    $resultado = mysqli_query($conexion, $consulta);
    while($fila = $resultado->fetch_assoc()){
    $ids[]=$fila['idP'];
    }
    return $ids;
}
public function DevolverNumero($id){
    $numero=0;
    foreach($this->_pools as $pool){
     if($pool->getIdP()==$id){
        $numero=$pool->getNumero();
     }
       
    }
   return $numero;
}
public function mismoEstado($idPool,$estado){
    $existe=false;
    foreach($this->_pools as $pool){
        if($idPool==$pool->getidP() &&  $estado==$pool->getEstado()){
            $existe=true;
        }
    }
    return $existe;
}

public function retornarNumero($idP){
    foreach($this->_pools as $pool){
        if($idP==$pool->getIdp()){
            return $pool->getNumero();
        }
    }
}
public function poolTorneos($idT,$idP){
    $existe=false;
    $existeTiene=$this->ExisteTiene($idP);
    if($existeTiene){

    }
    else{
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $consulta= $conexion->prepare("INSERT INTO tiene (idP,IdT)  values (?,?)");
        $consulta->bind_param("ii",$idP,$idT);
        $success=$consulta->execute();
        if(!$success){
           $existe=true;
        }
        $consulta->close();
        $conexion->close();
        return $existe;  
    }
}
public function ExisteTiene($idP){
    $ids=[];
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = "SELECT * FROM tiene";
    $resultado = mysqli_query($conexion, $consulta);
    if (!$conexion) {
        die('Error en la conexión: ' . mysqli_connect_error());
    }
    if (!$resultado){
        die('Error en la consulta SQL: ' . $consulta);
    }
    while($fila = $resultado->fetch_assoc()){
        $ids[]=$fila['idP'];
    }
    if(empty($ids)){

    }
    else{
        if($ids[0]==$idP){
            return true;
        }
        $posicion=array_search($idP,$ids);
        if($posicion!=0){
            return true;
        }
    }
return false;
}

public function idPTiene($idTorneo){
    $ids=[];
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = "SELECT * FROM tiene order by idP DESC";
    $resultado = mysqli_query($conexion, $consulta);
    if (!$conexion) {
        die('Error en la conexión: ' . mysqli_connect_error());
    }
    if (!$resultado){
        die('Error en la consulta SQL: ' . $consulta);
    }
    while($fila = $resultado->fetch_assoc()){
        if($idTorneo==$fila['idT']){
            $ids[]=$fila['idP'];
        }
        
    }
    return $ids;
}
public function DevolverPool($ci){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = "SELECT * FROM estan";
    $resultado = mysqli_query($conexion, $consulta);
    if (!$conexion) {
        die('Error en la conexión: ' . mysqli_connect_error());
    }
    if (!$resultado){
        die('Error en la consulta SQL: ' . $consulta);
    }
    while($fila = $resultado->fetch_assoc()){
        if($fila['ciP']==$ci){
            return $this->DevolverNumero($fila['idP']);
        }
    }
}
public function poolSinGuardar($idTorneo){
    $ids=[];
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = "SELECT * FROM tiene";
    $resultado = mysqli_query($conexion, $consulta);
    if (!$conexion) {
        die('Error en la conexión: ' . mysqli_connect_error());
    }
    if (!$resultado){
        die('Error en la consulta SQL: ' . $consulta);
    }
    while($fila = $resultado->fetch_assoc()){
        if($idTorneo==$fila['idT']){
            $ids[]=$fila['idP'];
        }
        
    }
}
public function MayorId($idTorneo){
    $contador=0;
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = "SELECT * FROM pool";
    $resultado = mysqli_query($conexion, $consulta);
    if (!$conexion) {
        die('Error en la conexión: ' . mysqli_connect_error());
    }

    if (!$resultado){
        die('Error en la consulta SQL: ' . $consulta);
    }

    while($fila = $resultado->fetch_assoc()){
        if($contador<$fila['idP']){ 
            $contador=$fila['idP'];
        }
    }
    return $contador;
}

public function RangoPools($idTorneo){
    $ids=[];
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = $conexion->prepare("select pool.idP from pool join tiene on pool.idP=tiene.idP where tiene.idT=?;");
    $consulta->bind_param("i",$idTorneo);
    $consulta->execute();
    $resultado = $consulta->get_result();
    while ($fila = $resultado->fetch_assoc()) {
        $ids[] = $fila['idP'];
    }
    $consulta->close();
    return $ids;
}
public function getIdPool($ci){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = $conexion->prepare("select idP from estan where notaFinal=0 and ciP=?");
    $consulta->bind_param("i",$ci);
    $consulta->execute();
    $idP=0;
    $resultado = $consulta->get_result();
    while ($fila = $resultado->fetch_assoc()){
        $idP=$fila['idP'];
    }
    return $idP;
 }

public function mismaEscuela($idEscuelas,$idTorneo){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $cis=[];
    $cisRespaldos=[];
shuffle($idEscuelas);
for($x=0;$x<count($idEscuelas);$x++){
$competidores=[];
$consulta2=$conexion->prepare("select estudia.* from estudia join compite on compite.ciP=estudia.ciP where idEscuela=? and  idTorneo=?;");
$idEscuela=$idEscuelas[$x];
$consulta2->bind_param("ii",$idEscuela,$idTorneo);
$consulta2->execute();
$idEscuela=0;
$idP=0;
$resultado2=$consulta2->get_Result();
while ($fila = $resultado2->fetch_assoc()){
    $competidores[]=$fila['ciP'];
}
shuffle($competidores);
$posicionCompetidores=count($competidores);
$cisRespaldos = array_merge($cisRespaldos,array_slice($competidores,0,$posicionCompetidores));
}
$posicionCis=count($cisRespaldos);
$cis = array_merge($cis, array_slice($cisRespaldos, 0, $posicionCis));
return $cis;
}
public function borrarEstan($idTorneo){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = $conexion->prepare("delete estan from estan join tiene on estan.idP=tiene.idP where idT=?");
    $consulta->bind_param("i",$idTorneo);
    $consulta->execute();
    $consulta->execute();
}
public function existePool($idTorneo,$idP){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $idsP=[];
    $consulta = $conexion->prepare("select * from pool join tiene on pool.idP=tiene.idP where idT=?;");
    $consulta->bind_param("i",$idTorneo);
    $consulta->execute();
    $resultado=$consulta->get_result();
    while ($fila = $resultado->fetch_assoc()){
       $idsP=$fila['idP'];
    }
  if(in_array($idP,$idsP)){
    return true;
  }
  else{
    return false;
  }
}
}
?>