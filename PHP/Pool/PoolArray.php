<?php
require_once ("Pool.php");
require_once ("C:/xampp/htdocs/ProgramaPhp/PHP/Participante/ParticipanteArray.php");
require_once ("C:/xampp/htdocs/ProgramaPhp/PHP/Torneo/TorneoArray.php");
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
        $arrayParticipantes= (array) $participantes->devolverArray();
        $estado="cerrado";
        $horaInicio="null";
        $horaFinal="null";
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        if (!$conexion) {
            die('Error en la conexión: ' . mysqli_connect_error());
        }
        $consulta = $conexion ->prepare("INSERT INTO Pool (estado,hora_inicio,hora_final,numero) values (?,?,?,?)");
        $consulta2 = "SELECT * FROM Pool";
        $resultado = mysqli_query($conexion, $consulta2);
        $idsPool=[];
        while($fila = $resultado->fetch_assoc()){
            $idsPool[]=$fila['idP'];
        }
        $consulta3 = $conexion ->prepare("INSERT INTO tiene (idP,idT) values (?,?)");
        if($cantParticipantes==3){
            $consulta->bind_param("sssi", $estado, $horaInicio,$horaFinal,1);
            $consulta->execute();
            $consulta->close();
            for($x=0;$x<count($idsPool);$x++){
            $consulta3->bind_param("ii",$idTorneo,$idsPool[$x]);
            $consulta3->execute();
            }
        }
        if($cantParticipantes==4){
          for($x=1;$x<=2;$x++){
            $consulta->bind_param("sssi", $estado, $horaInicio,$horaFinal,$x);
            $consulta->execute();
          }
          for($x=0;$x<count($idsPool);$x++){
            $consulta3->bind_param("ii",$idTorneo,$idsPool[$x]);
            $consulta3->execute();
            }
        }
        if($cantParticipantes==5){
            for($x=1;$x<=4;$x++){
              $consulta->bind_param("sssi", $estado, $horaInicio,$horaFinal,$x);
              $consulta->execute();
        
            }
            for($x=0;$x<count($idsPool);$x++){
                $consulta3->bind_param("ii",$idTorneo,$idsPool[$x]);
                $consulta3->execute();
                }
          }
          if($cantParticipantes>5 && $cantParticipantes<=10){
            for($x=1;$x<=5;$x++){
              $consulta->bind_param("sssi", $estado, $horaInicio,$horaFinal,$x);
              $consulta->execute();
            }
            for($x=0;$x<count($idsPool);$x++){
                $consulta3->bind_param("ii",$idTorneo,$idsPool[$x]);
                $consulta3->execute();
                }
          }
          if($cantParticipantes>10 && $cantParticipantes<=24){
            for($x=1;$x<=7;$x++){
              $consulta->bind_param("sssi", $estado, $horaInicio,$horaFinal,$x);
              $consulta->execute();
            }
            for($x=0;$x<count($idsPool);$x++){
                $consulta3->bind_param("ii",$idTorneo,$idsPool[$x]);
                $consulta3->execute();
                }
          }
          if($cantParticipantes>24 && $cantParticipantes <=48){
            for($x=1;$x<=11;$x++){
              $consulta->bind_param("sssi", $estado, $horaInicio,$horaFinal,$x);
              $consulta->execute();
            }
            for($x=0;$x<count($idsPool);$x++){
                $consulta3->bind_param("ii",$idTorneo,$idsPool[$x]);
                $consulta3->execute();
                }
          }
          if($cantParticipantes>49 && $cantParticipantes <=96){
            for($x=1;$x<=19;$x++){
              $consulta->bind_param("ssis", $estado, $horaInicio,$horaFinal,$x);
              $consulta->execute();
            }
            for($x=0;$x<count($idsPool);$x++){
                $consulta3->bind_param("ii",$idTorneo,$idsPool[$x]);
                $consulta3->execute();
                }
          }      
          echo "<p style='color:green'>pools creados correctamente reinice la pagina para ver los cambios </p>";
}  
    public function Listar(){
       
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $consulta = "SELECT * FROM Pool";
        $resultado = mysqli_query($conexion, $consulta);
        if (!$resultado){
            die('Error en la consulta SQL: ' . $consulta);
        }
        echo "<table border='2'>";
        echo "<tr> <td> Estado </td> <td> Hora inicio </td> <td> Id pool </td> </td><td> Hora cierre </td> </tr> ";
        while($fila = $resultado->fetch_assoc()){
            echo "<tr> <td>".$fila['estado']. " </td><td>" . $fila['hora_inicio'] . "</td><td>  " . $fila['idP'] . "</td> <td>" . $fila['hora_final']. "</td> </tr>";
        }
        echo "</table>";
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
    
    public function MostrarAsignados(){
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $consulta = "SELECT * FROM estan";
        $resultado = mysqli_query($conexion, $consulta);
        $ids=$this->idsEstan();
        if (!$resultado){
            die('Error en la consulta SQL: ' . $consulta);
        }
        $pools=[];
        
        echo "<table border='2'>";
        $ci=[];
        while($fila = $resultado->fetch_assoc()){
            $ci[]=$fila['ciP'];
        }
        echo "<tr> <td> ciP </td> <td> Pool </td> </tr>";
        for($x=0;$x<count($ci);$x++){
            echo "<tr> <td>".$ci[$x]. " </td><td>" . $this->DevolverNumero($ids[$x]). "</td> </tr>";
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
        $ids=[];
        $id=0;
        $consulta2= "SELECT * FROM pool";
        $resultado = mysqli_query($conexion, $consulta2);
        shuffle($ciParticipantes);
        if (!$resultado){
            die('Error en la consulta SQL: ' . $consulta2);
        }
        while($fila = $resultado->fetch_assoc()){
          $ids[]=$fila['idP'];
        }
        $notaFinal=0;
        $clasificados="null";
        if (count($participantesMismaCategoria) < 3) {
            echo "el torneo se realizará a partir de 3 participantes";
        }
        if (count($ciParticipantes) == 3) {
            echo "hola";
            $consulta = $conexion ->prepare(
            "INSERT INTO  estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
            for($x=0;$x<count($participantesMismaCategoria);$x++){
                $consulta->bind_param("iiis", $ciParticipantes[$x],$ids[$x],$notaFinal,$clasificados);
                $success=$consulta->execute();
                if(!$success){
                    echo $consulta->error();
                }
            }
            $consulta->close();
            $conexion->close();

        } elseif (count($ciParticipantes) == 4) {
            $consulta = $conexion->prepare(
            "INSERT INTO  estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
            for($x=0;$x<count($participantesMismaCategoria);$x++){
                $consulta->bind_param("iiis", $ciParticipantes[$x],$ids[$id],$notaFinal,$clasificados); 
                $consulta->execute();
                if($x>=1){
                    $id=1;
                }
            }

        } elseif (count($ciParticipantes) == 5) {
            $consulta = $conexion ->prepare(
            "INSERT INTO  estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
            for($x=0;$x<count($participantesMismaCategoria);$x++){
            $consulta->bind_param("iiis", $ciParticipantes[$x],$ids[$id],$notaFinal,$clasificados); 
            $success=$consulta->execute();
                    if($x>=2){
                        $id=1;
                    }
                }

        } elseif (count($ciParticipantes) > 5 && count($ciParticipantes) <= 10) {
            $consulta = $conexion ->prepare("INSERT INTO  estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
            for($x=0;$x<count($participantesMismaCategoria);$x++){
            $consulta->bind_param("iiis", $ciParticipantes[$x],$ids[$id],$notaFinal,$clasificados); 
            $consulta->execute();
                if($x>=4){
                    $id=1;
                }
            }

        } elseif (count($ciParticipantes) > 10 && count($ciParticipantes)<=24) {
            $consulta = $conexion ->prepare("INSERT INTO estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
            $pool1=count($participantesMismaCategoria)/2;
            $uno=1;
            $dos=2;
            for($x=1;$x<=count($participantesMismaCategoria);$x++){ 
                if($x>$pool1){
                    $consulta->bind_param("iiis", $ciParticipantes[$x-1],$ids[$id],$notaFinal,$clasificados);
                    $consulta->execute();
                }
                else{
                    $consulta->bind_param("iiis", $ciParticipantes[$x-1],$id[2],$notaFinal,$clasificados); 
                    $consulta->execute();
                }
            }
            $consulta->close();
        } elseif (count($ciParticipantes) > 24 && count($ciParticipantes)<49){ 
            $consulta = $conexion ->prepare("INSERT INTO estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
            $cantpool=count($ciParticipantes)/4 -1; 
            $contador=0;
            $pool=1;
            for($x=1;$x<=count($ciParticipantes);$x++){ 
                if($contador>$cantpool && $pool!=4){
                    $pool++;
                    $contador=0;
                }
                $consulta->bind_param("iiii",$ciParticipantes[$x-1],$pool,$notaFinal,$clasificados);
                $consulta->execute();
                $contador++;
            }
            $consulta->close(); 
        } elseif (count($ciParticipantes) > 48 && count($ciParticipantes)<97){
            $consulta = $conexion ->prepare("INSERT INTO estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
            $cantpool=count($ciParticipantes)/8-1;
            $cambiarPool=false;
            $contador=0;
            $pool=1;
            
            for($x=1;$x<=count($ciParticipantes);$x++){ 
                if($pool==8 && $cambiarPool){
                    $pool=1;
                }
                
                if($contador>$cantpool){
                    $pool++;
                    $id++;
                    if($pool==9 && !$cambiarPool){
                        $pool-=1;
                        $cambiarPool=true;
                        $contador=0;
                    }
                    else{
                        $contador=0;
                    }
                    
                }
                $consulta->bind_param("iiii",$ciParticipantes[$x-1],$numero,$notaFinal,$clasificados);
                $success=$consulta->execute();
                if(!$success){
                    echo $consulta->error;
                }
                if($cambiarPool && $pool!=8){
                    $pool++;
                    $id++;   
                   }
                   else{
                    $contador++;
                   }
        }
    }
}

    public function cantPools(){
        $contador=0;
        foreach($this->_pools as $pool){
            if($contador<$pool->getIdP()){
                $contador=$pool->getIdP();
            }
        }
        return $contador;
    } 
public function cantRondas(){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);    
    $rondas=[];
    $cantRondas=1;
    $consulta="SELECT * FROM utiliza2";
    $resultado = mysqli_query($conexion, $consulta);
    while($fila = $resultado->fetch_assoc()){
    $rondas[]=$fila['ronda'];
}
   for($x=0;$x<count($rondas);$x++){
    if($cantRondas<$rondas[$x]){
       $cantRondas=$rondas[$x];
    }
   }
return $cantRondas;
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
}
?>