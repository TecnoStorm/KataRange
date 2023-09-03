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
            $this->_pools= new Pool($fila['estado'],$fila['hora_inicio'],$fila['idP'],$fila['hora_final']);
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
        $resultado = mysqli_query($conexion, $consulta);
        $idsPool=[];
        while($fila = $resultado->fetch_assoc()){
            $idsPool[]=$fila['idP'];
        }
        $consulta3 = $conexion ->prepare("INSERT INTO tiene (idP,idT) values (?,?)");
        if($cantParticipantes==3){
            $consulta->bind_param("ssis", $estado, $horaInicio,$horaFinal,1);
            $consulta->execute();
            $consulta->close();
            for($x=0;$x<count($idsPool);$x++){
            $consulta3->bind_param("ii",$idTorneo,$idsPool[$x])
            $consulta3->execute();
            }
        }
        if($cantParticipantes==4){
          for($x=1;$x<=2;$x++){
            $consulta->bind_param("ssis", $estado, $horaInicio,$horaFinal,$x);
          }
          for($x=0;$x<count($idsPool);$x++){
            $consulta3->bind_param("ii",$idTorneo,$idsPool[$x])
            $consulta3->execute()
            }
        }
        if($cantParticipantes==5){
            for($x=1;$x<=4;$x++){
              $consulta->bind_param("ssis", $estado, $horaInicio,$horaFinal,$x);
            }
            for($x=0;$x<count($idsPool;$x++)){
                $consulta3->bind_param("ii",$idTorneo,$idsPool[$x])
                $consulta3->execute()
                }
          }
          if($cantParticipantes>5 && $cantParticipantes<=10){
            for($x=1;$x<=5;$x++){
              $consulta->bind_param("ssis", $estado, $horaInicio,$horaFinal,$x);
            }
            for($x=0;$x<count($idsPool;$x++)){
                $consulta3->bind_param("ii",$idTorneo,$idsPool[$x])
                $consulta3->execute()
                }
          }
          if($cantParticipantes>10 && $cantParticipantes<=24){
            for($x=1;$x<=7;$x++){
              $consulta->bind_param("ssis", $estado, $horaInicio,$horaFinal,$x);
            }
            for($x=0;$x<count($idsPool;$x++)){
                $consulta3->bind_param("ii",$idTorneo,$idsPool[$x])
                $consulta3->execute()
                }
          }
          if($cantParticipantes>24 && $cantParticipantes <=48){
            for($x=1;$x<=11;$x++){
              $consulta->bind_param("ssis", $estado, $horaInicio,$horaFinal,$x);
            }
            for($x=0;$x<count($idsPool;$x++)){
                $consulta3->bind_param("ii",$idTorneo,$idsPool[$x])
                $consulta3->execute()
                }
          }
          if($cantParticipantes>49 && $cantParticipantes <=96){
            for($x=1;$x<=19;$x++){
              $consulta->bind_param("ssis", $estado, $horaInicio,$horaFinal,$x);
            }
            for($x=0;$x<count($idsPool;$x++)){
                $consulta3->bind_param("ii",$idTorneo,$idsPool[$x])
                $consulta3->execute()
                }
          }      
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
        if (!$resultado){
            die('Error en la consulta SQL: ' . $consulta);
        }
        echo "<table border='2'>";
        echo "<tr> <td> ciP </td> <td> Pool </td> </tr>";
        while($fila = $resultado->fetch_assoc()){
            echo "<tr> <td>".$fila['ciP']. " </td><td>" . $fila['idP'] . "</td> </tr>";
        }
        echo "</table>";
    }

    public function AsignarPool($idTorneo){
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $torneos=new TorneoArray();
        $participantesMismaCategoria=$torneos->mismaCategoria();
        $ciParticipantes=$torneos->ciParticipantesTorneoPools($idTorneo); 
        var_dump($ciParticipantes);
        $participantes=new ParticipanteArray();
        $participantesArray=$participantes->devolverArray();
        $ids=$this->idsPool();
        $notaFinal=0;
        $clasificados="null";
        shuffle($participantesMismaCategoria);
        if (count($participantesMismaCategoria) < 3) {
            echo "el torneo se realizará a partir de 3 participantes";
        }
        if (count($participantesMismaCategoria) == 3) {
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

        } elseif (count($participantesMismaCategoria) == 4) {
            $consulta = $conexion->prepare(
            "INSERT INTO  estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
            for($x=0;$x<count($participantesMismaCategoria);$x++){
                $consulta->bind_param("iiis", $ciParticipantes[$x],$id,$notaFinal,$clasificados); 
                $consulta->execute();
                if($x>=1){
                    $id=2;
                }
            }

        } elseif (count($participantesMismaCategoria) == 5) {
            $consulta = $conexion ->prepare(
            "INSERT INTO  estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
            for($x=0;$x<count($participantesMismaCategoria);$x++){
            $consulta->bind_param("iiis", $ciParticipantes[$x],$id,$notaFinal,$clasificados); 
            $consulta->execute();
                    if($x>=2){
                        $id=2;
                    }
                }

        } elseif (count($participantesMismaCategoria) > 5 && count($participantesMismaCategoria) <= 10) {
            $consulta = $conexion ->prepare(
            "INSERT INTO  estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
            for($x=0;$x<count($participantesMismaCategoria);$x++){
            $consulta->bind_param("iiis", $ciParticipantes[$x],$id,$notaFinal,$clasificados); 
            $consulta->execute();
                if($x>=4){
                    $id=2;
                }
            }

        } elseif (count($participantesMismaCategoria) > 10 && count($participantesMismaCategoria)<=24) {
            $consulta = $conexion ->prepare("INSERT INTO estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
            $pool1=count($participantesMismaCategoria)/2;
            $uno=1;
            $dos=2;
            for($x=1;$x<=count($participantesMismaCategoria);$x++){ 
                if($x>$pool1){
                    $consulta->bind_param("iiis", $ciParticipantes[$x-1],$dos,$notaFinal,$clasificados);
                    $consulta->execute();
                }
                else{
                    $consulta->bind_param("iiis", $ciParticipantes[$x-1],$uno,$notaFinal,$clasificados); 
                    $consulta->execute();
                }
            }
            $consulta->close();
        } elseif (count($participantesMismaCategoria) > 24 && count($participantesMismaCategoria)<49){ 
            $consulta = $conexion ->prepare("INSERT INTO estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
            $cantpool=count($participantesMismaCategoria)/4 -1; 
            $contador=0;
            $pool=1;
            for($x=1;$x<=count($participantesMismaCategoria);$x++){ 
                if($contador>$cantpool && $pool!=4){
                    $pool++;
                    $contador=0;
                }
                $consulta->bind_param("iiii",$ciParticipantes[$x-1],$pool,$notaFinal,$clasificados);
                $consulta->execute();
                $contador++;
            }
            $consulta->close(); 
        } elseif (count($participantesMismaCategoria) > 48 && count($participantesMismaCategoria)<97){
            $consulta = $conexion ->prepare("INSERT INTO estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
            $cantpool=count($participantesMismaCategoria)/8-1;
            $cambiarPool=false;
            $contador=0;
            $pool=1;
            for($x=1;$x<=count($participantesMismaCategoria);$x++){ 
                if($pool==8 && $cambiarPool){
                    $pool=1;
                }
                
                if($contador>$cantpool){
                    $pool++;
                    if($pool==9 && !$cambiarPool){
                        $pool-=1;
                        $cambiarPool=true;
                        $contador=0;
                    }
                    else{
                        $contador=0;
                    }
                    
                }
                $consulta->bind_param("iiii",$ciParticipantes[$x-1],$pool,$notaFinal,$clasificados);
                $consulta->execute();
                if($cambiarPool && $pool!=8){
                    $pool++;   
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
    ids=[]
    foreach($this->_pools as $pool){
        $ids[]=$pool->getId();
    }
    return $ids;
}
}
?>