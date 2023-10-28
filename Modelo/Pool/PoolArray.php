<?php
require_once ("Pool.php");
require_once ("C:/xampp/htdocs/ProgramaPhp/Modelo/Participante/ParticipanteArray.php");
require_once ("C:/xampp/htdocs/ProgramaPhp/Modelo/Torneo/TorneoArray.php");
    class PoolArray{
    private $_pools=array();

    public function __construct(){
        $consulta = "SELECT * FROM Pool";
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
        $consulta = $conexion ->prepare("INSERT INTO Pool (estado,hora_inicio,hora_final,numero) values (?,?,?,?)");

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
            echo "HOLAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA";
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
          $consulta2 = "SELECT * FROM Pool";
            $resultado = mysqli_query($conexion, $consulta2);
            while($fila = $resultado->fetch_assoc()){
                if($fila['idP']>$mayorPool){
                    $idsPool[]=$fila['idP'];
                }
                
                for($x=0;$x<count($idsPool);$x++){
                    $consulta3->bind_param("ii",$idsPool[$x],$idTorneo);
                    $consulta3->execute();
                }
            }
          echo "<p style='color:green'>pools creados correctamente reinice la pagina para ver los cambios </p>";
    }

    public function Listar($idTorneo){
        $ids=$this->idPTiene($idTorneo);
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $consulta = $conexion->prepare("SELECT * FROM Pool where idP=?");
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
    
    public function EditarPool($id,$estado){ 
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $consulta = $conexion ->prepare(
            "UPDATE Pool SET estado = ? WHERE idP=?;");
            $consulta2 = $conexion ->prepare(
                "UPDATE Pool SET hora_inicio = NOW()  WHERE idP=?;"); 
                $consulta3 = $conexion ->prepare(
                    "UPDATE Pool SET hora_final = NOW()  WHERE idP=?;"); 
            if($estado=="abierto"){
                $consulta->bind_param("si", $estado,$id);
                $consulta->execute();
                $consulta->close();
                $consulta2->bind_param("i", $id);
                $consulta2->execute();
                $consulta2->close();
            }
            else{
                $consulta->bind_param("si", $estado,$id);
                $consulta->execute();
                $consulta->close();
                $consulta3->bind_param("i", $id);
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
        
        echo "<table border='1'> 
        <tr> <td> CI Participante </td> <td> Nombre </td> <td> Pool </td> <td> Cinturón </td> </tr>"; 
        while($fila = $resultado->fetch_assoc()){
            echo "<tr> <td>".$fila['Ci participante']. " </td><td>" . $fila['nombre']. "</td><td>". $fila['pool'] . "</td><td>". $fila['Cinturon']."</td></tr>";
        }
        echo "</table>";
    }

    public function AsignarPool($idTorneo){
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $torneos=new TorneoArray();
        $participantesMismaCategoria=$torneos->mismaCategoria();
        $ciParticipantes=$torneos->ciParticipantesTorneoPools($idTorneo);
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
                $consulta->bind_param("iiis", $ciParticipantes[$x],$ids[$id],$notaFinal,$clasificados); 
                $consulta->execute();
                $consulta2->bind_param("si",$cinturon,$ciParticipantes[$x]);
                $consulta2->execute();
                $consulta3->bind_param("iiii",$ciParticipantes[$x],$cero,$uno,$ids[$id]);
                $consulta3->execute();
                if($x>=1){
                    $id=1;
                    $cinturon="Ao";
                }
            }
           $consulta->close();
           $consulta2->close();
        } elseif (count($ciParticipantes) == 5) {
            $cinturon="Aka";
            $consulta = $conexion ->prepare("INSERT INTO  estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
            $consulta2=$conexion->prepare("Update compite set cinturon=? where ciP=?");
            $consulta3=$conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda,idP) values (?,?,?,?)");
            
            for($x=0;$x<count($participantesMismaCategoria);$x++){
            
            $consulta->bind_param("iiis", $ciParticipantes[$x],$ids[$id],$notaFinal,$clasificados); 
            $consulta->execute();
            $consulta3->bind_param("iiii",$ciParticipantes[$x],$cero,$uno,$ids[$id]);
            $consulta3->execute();
            $consulta2->bind_param("si",$cinturon,$ciParticipantes[$x]);
                    $consulta2->execute();        
                    if($x>=2){
                        $id=1;
                        $cinturon="Ao";
                    }
                }
                

        } elseif (count($ciParticipantes) > 5 && count($ciParticipantes) <= 10) {
            $consulta = $conexion ->prepare("INSERT INTO  estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
            $consulta2=$conexion->prepare("Update compite set cinturon=? where ciP=?");
            $consulta3=$conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda,idP) values (?,?,?,?)");
            $cinturon="Aka";
            for($x=0;$x<count($ciParticipantes);$x++){
                if($x>(count($ciParticipantes)/2)-1){
                    $id=1;
                    $cinturon="Ao";
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
            for($x=1;$x<=count($participantesMismaCategoria);$x++){ 
                if($x>$pool1){
                    $cinturon="Aka";
                    $consulta->bind_param("iiis", $ciParticipantes[$x-1],$idsTiene[6],$notaFinal,$clasificados);
                    $consulta->execute();
                    $consulta2->bind_param("si",$cinturon,$ciParticipantes[$x-1]);
                    $consulta2->execute();
                    $consulta3->bind_param("iiii",$ciParticipantes[$x-1],$cero,$uno,$idsTiene[6]);
                    $consulta3->execute();
                }
                else{
                    $cinturon="Ao";
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
            for($x=1;$x<=count($ciParticipantes);$x++){ 
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
            $cantpool=count($ciParticipantes)/8 -1;
            $cambiarPool=false;
            $contador=0;
            $contador2=0;
            $pool=1;
            $posicion=9;
            $id=11;
            $idKata=0;
            for($x=1;$x<=count($ciParticipantes);$x++){ 
                if($pool==9 && $cambiarPool){
                    $pool=1;
                    $id=11;
                    echo "holaaaaaaaa";
                }
                    if($contador>$cantpool){
                        $pool++;
                        $id++;
                        if($pool==9 && !$cambiarPool){
                            $id=18;
                            $pool=1;
                            $cambiarPool=true;
                            $contador=0;
                    
                        }
                        else{
                            $contador=0;
                        }
                        
                    }
                
               
                $contador2++;
                $consulta->bind_param("iiii",$ciParticipantes[$x-1],$idsTiene[$id],$notaFinal,$clasificados);
                $consulta->execute();
                $consulta3->bind_param("iiii",$ciParticipantes[$x-1],$idKata,$uno,$idsTiene[$id]);
                $consulta3->execute();
                if($cambiarPool && $pool!=8){
                    $pool++;
                    $id--;   
                   }
                   else{
                    $contador++;
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
}
?>