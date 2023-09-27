<?php
require_once ('Nota.php');
require_once ("C:/xampp/htdocs/ProgramaPhp/Controlador/config.php");
require_once ("C:/xampp/htdocs/ProgramaPhp/Modelo/Pool/PoolArray.php");
require_once ("C:/xampp/htdocs/ProgramaPhp/Modelo/Torneo/TorneoArray.php");
require_once ("C:/xampp/htdocs/ProgramaPhp/Modelo/Participante/ParticipanteArray.php");
class NotaArray{
    private $_notas=array();
    public function __construct(){
        $consulta = "select estan.*,pool.numero from estan join pool where estan.idP=pool.idP order by idP DESC,notaFinal desc;";
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $resultado = mysqli_query($conexion, $consulta);
        if (!$conexion) {
            die('Error en la conexión: ' . mysqli_connect_error());
        }
        if (!$resultado){
            die('Error en la consulta SQL: ' . $consulta);
            }
        while($fila = $resultado->fetch_assoc()){
            $this->_notas[]= new Nota($fila['ciP'],$fila['idP'],$fila['notaFinal'],$fila['Clasificados'],$fila['numero']);
        }
    }

    public function ganadorPool($pool){
        $ganador=0;
        $posicion=0;
        foreach($this->_notas as $clave => $nota){
            if($nota->getIdP()==$pool){
                if($ganador<$nota->getNotaFinal()){
                    $ganador=$nota->getNotaFinal();
                    $posicion=$clave;
                }
            }
        }
        return $posicion;
    }
    
    public function ganadores($idTorneo){
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $notas=$this->notasTorneo($idTorneo);
        $pools=new PoolArray();
        $cantRondas=$pools->cantRondas($idTorneo);
        $participantes=new ParticipanteArray();
        $cantParticipantes=$participantes->cantParticipantesTorneo($idTorneo);
        $cantidadPools=$pools->cantPools($idTorneo);
        $poolsTiene=$pools->idPTiene($idTorneo);
        $torneos=new TorneoArray();
        $existePuesto=$torneos->puestos();
        $consulta = $conexion ->prepare("UPDATE compite SET puesto = ?  WHERE ciP=? and idTorneo=? ;"); 
        //torneo de a tres--------------------------------------------------------------------------------------------------------
        if(count($notas)==3){
            for($x=0;$x<count($notas);$x++){
                $puesto=1+$x;
                $consulta->bind_param("iii", $puesto, $notas[$x]->getCiP(),$idTorneo);
                $consulta->execute();
            }
            $consulta->close();
            $this->mostrarGanadores($idTorneo);
        }
        //torneo de a cuatro--------------------------------------------------------------------------------------------------------
        if(count($notas)==4){
            $tercero="3ro";
            $posicionTercero=0; 
            $existe=false;
            $clasificados[]=$notas[0];
            $clasificados[]=$notas[2];
            for($x=0;$x<count($notas);$x++){ 
                if($notas[$x]->getNumero()==3 && $notas[$x]->getNotaFinal()!=0){
                    $existe=true;
                }
            }
            if($existe){
                $consulta3 = $conexion ->prepare("UPDATE compite SET puesto = ?  WHERE ciP=? and idTorneo=?;"); 
                $consulta4 = $conexion ->prepare("UPDATE compite SET puesto = ?  WHERE ciP=? and idTorneo=? ;"); 
                $contador=0; 
                foreach($notas as $clave => $nota){ 
                    if($cantidadPools <4 && $nota->getNumero()==3 || $cantidadPools==4 && $nota->getNumero()==4){
                        echo "no se donde estoy"; 
                        $puesto='1ro';
                        $posicion=$clave+1;
                        if($posicion>1){
                            $puesto='2do';
                        }
                        echo "posicion:" .$posicion."puesto:". $puesto;
                        $consulta3->bind_param("iii",$puesto,$nota->getCiP(),$idTorneo); 
                        $consulta3->execute();
                    }
                    else{
                        if($existePuesto){
                            if($contador<$nota->getNotaFinal()){
                                $contador=$nota->getNotaFinal();
                                $posicionTercero=$clave; 
                                echo $contador;
                            }
                        }
                        else{
                            $consulta3 = $conexion ->prepare("UPDATE compite SET puesto = ?  WHERE ciP=? and idTorneo=? ;"); 
                            $consulta3->bind_param("iii", $tercero,$nota->getCiP(),$idTorneo);
                            $consulta3->execute();
                            }    
                        }
                    } 
                
                    if($existePuesto){
                        $quinto=5;
                        $cero=0;
                        $consulta4->bind_param("iii",$tercero,$notas[$posicionTercero]->getCiP(),$idTorneo);
                        echo $notas[$posicionTercero]->getCiP(); 
                        $consulta4->execute();
                        $consulta4->close();
                    }
                    $this->mostrarGanadores($idTorneo);
                }
                else{
                    $nota0=0; 
                    $pool=$poolsTiene[0];
                    $consulta = $conexion ->prepare("INSERT INTO  estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
                    for($x=0;$x<2;$x++){
                        $consulta2=$conexion->prepare("delete estan from estan join compite on estan.ciP=compite.ciP where estan.ciP=? and idTorneo=?;
                        ");
                        $consulta2->bind_param("ii", $clasificados[$x]->getCiP(),$idTorneo);
                        $consulta2->execute();
                        $consulta->bind_param("iiis",$clasificados[$x]->getCiP(),$pool,$nota0,$clasificados[$x]->getClasificados());
                        $success=$consulta->execute();
                        if(!$success){
                            echo $consulta->error;
                        }
                    }
                    $consulta->close();
                    $consulta2->close();
                    $conexion->close();
                    echo "siguiente ronda";
                    echo "<a href='NotaKata.php'> Volver </a>";
                }
            }
//torneo de a 5--------------------------------------------------------------------------------------------------------
        if(count($notas)==5){
            $existe=false;
            $tercero=3;
            $clasificados[]=$notas[0];
            $clasificados[]=$notas[2]; 
            $clasificadosTerceros[]=$notas[1];
            $clasificadosTerceros[]=$notas[4];
            $consulta3 = $conexion ->prepare("UPDATE compite SET puesto = ?  WHERE ciP=? and idTorneo=?;");
            $consulta3->bind_param("iii",$tercero,$notas[3]->getCiP(),$idTorneo); 
            $consulta3->execute();
            $consulta3->close();
            $consulta5=$conexion->prepare("delete estan from estan join compite on estan.ciP=compite.ciP where estan.ciP=? and idTorneo=?;
            ");
            $consulta5->bind_param("ii",$notas[3]->getCiP(),$idTorneo);
            $consulta5->execute();
            $consulta5->close();
            for($x=0;$x<count($notas);$x++){ 
                if($notas[$x]->getNumero()==3 && $notas[$x]->getNotaFinal()!=0){
                    $existe=true;
                }
            }
            $nota0=0; 
            $poolFinal=$poolsTiene[0];
            $poolTerceros=$poolsTiene[1];
            $consulta = $conexion ->prepare("INSERT INTO  estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
            $consultaCambio=$conexion->prepare("update estan estan join compite on estan.ciP=compite.ciP set estan.idP=?,estan.notaFinal=0 where estan.ciP=? and idTorneo=?;");
            for($x=0;$x<2;$x++){
                $consulta2=$conexion->prepare("delete estan from estan join compite on estan.ciP=compite.ciP where estan.ciP=? and idTorneo=?;
                ");
                $consulta2->bind_param("ii", $clasificados[$x]->getCiP(),$idTorneo);
                $consulta2->execute();
                $consulta2->close();
                $consulta->bind_param("iiis",$clasificados[$x]->getCiP(),$poolFinal,$nota0,$clasificados[$x]->getClasificados());
                $consulta->execute();
                $consultaCambio->bind_param("iii",$poolTerceros,$clasificadosTerceros[$x]->getCiP(),$idTorneo);
                $consultaCambio->execute();
            }
            $consulta->close();
            $consultaCambio->close();
            $conexion->close();
            echo "siguiente ronda";
            echo "<a href='NotaKata.php'> Volver </a>";
        }
        //torneo de 5 a 10--------------------------------------------------------------------------------------------------------
        if(count($notas)>5 && count($notas)<=10){    
                
                    if($notas[0]->getNumero()==4){  
                        $consulta = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
                        $consulta2 = $conexion->prepare("DELETE utiliza2 FROM utiliza2 join compite on utiliza2.ciP=compite.ciP where idTorneo=?");
                        $consulta2->bind_param("i",$idTorneo);
                        $consulta2->execute();
                        $consulta2->close();
                        $consulta4= $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?)");
                        $cero = 0;
                        $tres=3;
                        $clasificados4=[];
                        $clasificados3=[];
                        $posicion=0;
                        $clasificados4 = array_slice($notas, 0, 3);
                        $pool3=[];
                        foreach($notas as $nota){
                            if($nota->getNumero()==3){
                                array_push($pool3,$nota);
                            }
                        }
                        $clasificados3=array_slice($pool3,0,3);
                        $consulta3 = $conexion->prepare("delete estan from estan join compite on estan.ciP=compite.ciP where idTorneo=?");
                        $consulta3->bind_param("i",$idTorneo);
                        $consulta3->execute(); 
                        $consulta3->close();
                        for($x=1;$x<=count($clasificados4);$x++){
                            $consulta->bind_param("iii", $clasificados4[$x-1]->getCiP(),$poolsTiene[$x-1], $cero); 
                            $success1 = $consulta->execute();
                            if (!$success1) {
                                echo "Error en consulta 1: " . $consulta->error;
                            }
                            $consulta4->bind_param("iii",$clasificados4[$x-1]->getCiP(),$cero,$tres);
                            $consulta4->execute();
                            $consulta->bind_param("iii",$clasificados3[$x-1]->getCiP(),$poolsTiene[$posicion], $cero); 
                            $consulta->execute();
                            $consulta4->bind_param("iii",$clasificados3[$x-1]->getCiP(),$cero,$tres);
                            if ($x == 1) {
                                $posicion = 2;
                            } elseif ($x == 2) {
                                $posicion = 1;
                            }
                            
                        }
                        $consulta->close();

                    }
                    else{
                        if($cantRondas==4 && $cantParticipantes>24 && $cantParticipantes<49 ||$cantRondas==5 && $cantParticipantes>48 && $cantParticipantes<97 || $cantRondas==2 && $cantParticipantes>5 && $cantParticipantes<10 || $cantRondas==3 && $cantParticipantes >10 && $cantParticipantes<=24){
                            $contador=1;
                            $consulta = $conexion ->prepare("UPDATE compite SET puesto = ?  WHERE ciP=? and idTorneo=?;");
                            $tercero=3;
                            for($x=0;$x<2;$x++){
                                $consulta->bind_param("iii", $contador, $notas[$x]->getCiP(),$idTorneo);
                                $consulta->execute();
                                $contador++;
                            }
                            $posicion3=$this->ganadorPool($notas[2]->getIdP());
                            $posicion32=$this->ganadorPool($notas[4]->getIdP());
                            $consulta->close();
                            $consulta2 = $conexion->prepare("UPDATE compite SET puesto = ?  WHERE ciP=? and idTorneo=?");
                            $consulta3 = $conexion->prepare("UPDATE compite SET puesto = ?  WHERE ciP=? and idTorneo=?");
                            $consulta2->bind_param("iii", $tercero, $notas[$posicion3]->getCiP(),$idTorneo);
                            $consulta3->bind_param("iii", $tercero, $notas[$posicion32]->getCiP(),$idTorneo);
                            $consulta2->execute();
                            $consulta2->close();
                            $consulta3->execute();
                            $consulta3->close();
                            $this->mostrarGanadores($idTorneo);
                        }
                        else{ 
                            $ronda = 2;
                            if($cantRondas==3){
                                foreach ($notas as $nota) {
                                    if ($nota->getNumero() == 6) {
                                        $pool1[] = $nota;
                                    } else {
                                        $pool2[] = $nota;
                                    }
                                }
                                $ronda=4;
                            }
                            else{
                                foreach ($notas as $nota) {
                                    if ($nota->getNumero() == 1) {
                                        $pool1[] = $nota;
                                    } else {
                                        $pool2[] = $nota;
                                    }
                                }
                            }
                            $clasificados1=[];
                            $clasificados2=[];
                            $clasificados1=array_slice($pool1,0,3);
                            $clasificados2=array_slice($pool2,0,3) ;       
                            $consulta3 = $conexion->prepare("DELETE estan FROM estan join compite on estan.ciP=compite.ciP where idTorneo=?");
                            $consulta3->bind_param("i",$idTorneo);
                            $consulta3->execute(); 
                            $consulta3->close();         
                            $consulta = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
                            $consulta2 = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
                            $consulta4 = $conexion->prepare("delete utiliza2 from utiliza2 join compite on utiliza2.ciP=compite.cip where idTorneo=?");
                            $consulta4->bind_param("i",$idTorneo);
                            $consulta4->execute();
                            $consulta4->close();
                            $consulta5= $conexion->prepare("insert into utiliza2 (ciP,idKata,ronda) values (?,?,?);");
                            $posicion = 0;
                            $cero = 0;
                            
                            for($x=0;$x<count($clasificados1);$x++){                     
                                if ($x == 1) {
                                    $posicion = 2;
                                } elseif ($x == 2) {
                                    $posicion = 1;
                                }
                                $consulta->bind_param("iii", $clasificados1[$x]->getCiP(),$poolsTiene[$posicion], $cero);
                                $consulta5->bind_param("iii",$clasificados1[$x]->getciP(),$cero,$ronda);
                                $consulta->execute(); 
                                $consulta5->execute();
                                
                            }
                            $posicion=0;
                            for($x=0;$x<count($clasificados2);$x++){
                                if ($x == 1) {
                                    $posicion = 2;
                                } elseif ($x == 2) {
                                    $posicion = 1;
                                }
                                var_dump($clasificados2);     
                                $consulta2->bind_param("iii",$clasificados2[$posicion]->getCiP(),$poolsTiene[$posicion], $cero); 
                                $success=$consulta2->execute();
                                if(!$success){
                                    echo $consulta2->error;
                                }  
                                $consulta5->bind_param("iii",$clasificados2[$x]->getCiP(),$cero,$ronda);
                                $consulta5->execute();
                            }
                            
                            $consulta->close(); 
                            $consulta2->close();
                            $conexion->close();
                        } 
                    }
                
             
            }
//torneo de 10 a 24--------------------------------------------------------------------------------------------------------
    if(count($notas)>10 && count($notas) <=24){
        if($cantRondas==3){
            $clasificados14=[];
            $clasificados13=[];
            $dos=2;
            $cuatro=4;
            $uno=1;
            $clasificados14 = array_slice($notas, 0, 4);
            $pool13 = [];
            $pool15 = 15;
            $pool16 = 16;
            $posicion=0;
            $consulta = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
            $consulta2 = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
            $consulta3 = $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
            $consulta4 = $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
            $consulta5= $conexion->prepare("DELETE utiliza2 FROM utiliza2 join compite on utiliza2.ciP=compite.ciP where idTorneo=?");
            $consulta5->bind_param("i",$idTorneo);
            $consulta5->execute();
            $consulta5->close();
            foreach($notas as $nota){
                if($nota->getIdP()==13){
                    array_push($pool13,$nota);
                }
            }
            $clasificados13=array_slice($pool13,0,4);
            echo "<h1>hola</h1>";
            $consulta6= $conexion->prepare("DELETE estan FROM estan join compite on estan.ciP=compite.ciP where idTorneo=?");
            $consulta6->bind_param("i",$idTorneo);
            $consulta6->execute();
            $consulta6->close();
            for($x=0;$x<count($clasificados14);$x++){ 
                $consulta->bind_param("iii",$clasificados14[$x]->getCiP(),$pool16,$cero);
                $consulta2->bind_param("iii",$clasificados13[$x]->getCiP(),$pool15,$cero);
                $consulta3->bind_param("iii",$clasificados14[$x]->getCiP(),$uno,$cuatro); 
                $consulta4->bind_param("iii",$clasificados13[$x]->getCiP(),$uno,$cuatro);
                $consulta->execute();
                $consulta2->execute();
                $success1 = $consulta3->execute();
                if (!$success1) {
                    echo "Error en consulta 3: " . $consulta3->error;
                }
                $consulta4->execute();   
            }
            $consulta->close();
            $consulta2->close();
            $consulta3->close();
            $consulta4->close();   
        }
        else{
            if($cantRondas==2){
                $clasificados5=[];
                $clasificados6=[];
                $dos=2;
                $tres=3;
                $uno=1;
                $clasificados6 = array_slice($notas, 0, 4);
                $pool5 = [];
                $pool7 = 7;
                $pool8 = 8;
                $posicion=0;
                $consulta = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
                $consulta2 = $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
                $consulta3= $conexion->prepare("DELETE utiliza2 FROM utiliza2 join compite on utiliza2.ciP=compite.ciP where idTorneo=?");
                $consulta3->bind_param("i",$idTorneo);
                $consulta3->execute();
                $consulta3->close(); 
                foreach($notas as $nota){
                    if($nota->getNumero()==5){
                        array_push($pool5,$nota);
                    }
                }
                $clasificados5=array_slice($pool5,0,4);
                $consulta6= $conexion->prepare("DELETE estan FROM estan join compite on estan.ciP=compite.ciP where idTorneo=?");
                $consulta6->bind_param("i",$idTorneo);
                $consulta6->execute();
                $consulta6->close();
                echo "<h1>hola</h1>";
                for($x=0;$x<count($clasificados6);$x++){
                    $consulta->bind_param("iii",$clasificados5[$x]->getCiP(),$poolsTiene[7],$cero);
                    $consulta->execute();
                    $consulta->bind_param("iii",$clasificados6[$x]->getCiP(),$poolsTiene[8],$cero);
                    $consulta->execute();
                    $consulta2->bind_param("iii",$clasificados5[$x]->getCiP(),$uno,$tres); 
                    $consulta2->execute();
                    $consulta2->bind_param("iii",$clasificados6[$x]->getCiP(),$uno,$tres);
                    $consulta2->execute();
                    
                                    
            }
            $consulta->close();
            $consulta2->close();
        } 
            else{ 
                $clasificados1 = [];
                $dos=2;
                $cero=0;          
                $clasificados2 = array_slice($notas, 0, 4);
                $pool1 = [];
                $posicion=0;
                $consulta = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
                $consulta2 = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
                $consulta4 = $conexion->prepare("DELETE utiliza2 FROM utiliza2 join compite on utiliza2.ciP=compite.ciP where idTorneo=?");
                $consulta4->bind_param("i",$idTorneo);
                $consulta4->execute();
                $consulta4->close();
                $consulta5=$conexion->prepare("INSERT INTO utiliza2(ciP,idKata,ronda) VALUES(?,?,?)");
                foreach($notas as $nota){
                    if($nota->getNumero()==1){
                        array_push($pool1,$nota);
                    }
                }
                $clasificados1=array_slice($pool1,0,4);
                $consulta3 = $conexion->prepare("DELETE estan FROM estan join compite on estan.ciP=compite.ciP where idTorneo=?");
                $consulta3->bind_param("i",$idTorneo);
                $consulta3->execute(); 
                $consulta3->close(); 
                echo "<h1>hola</h1>";
                for($x=0;$x<count($clasificados1);$x++){
                    $consulta->bind_param("iii",$clasificados1[$x]->getCiP(),$poolsTiene[4],$cero);
                    $consulta2->bind_param("iii",$clasificados2[$x]->getCiP(),$poolsTiene[3],$cero);
                    $consulta5->bind_param("iii",$clasificados1[$x]->getCiP(),$cero,$dos);
                    $consulta5->execute();
                    $consulta5->bind_param("iii",$clasificados2[$x]->getCiP(),$cero,$dos);
                    $consulta5->execute();
                    $consulta->execute();
                    $consulta2->execute();
                }
                $consulta->close();
                $consulta2->close();
            }
        }
       
    }    
    //torneo de 25 a 49--------------------------------------------------------------------------------------------------------
        if(count($notas)>24 && count($notas) <49){
           if($cantRondas==2){
            $clasificados12=array_slice($notas,0,4);
            $pool11=[];
            $pool10=[];
            $pool9=[];
            $uno=1;
            $tres=3;
            foreach($notas as $nota){
                if($nota->getNumero()==11){
                    $pool11[]=$nota;
                }
                if($nota->getNumero()==10){
                    $pool10[]=$nota;
                }
                if($nota->getNumero()==9){
                    $pool9[]=$nota;
                }
            }
            $clasificados11=array_slice($pool11,0,4);
            $clasificados10=array_slice($pool10,0,4);
            $clasificados9=array_slice($pool9,0,4);
            $pool13=13;
            $pool14=14;
            $kata=1;  
            $consulta= $conexion->prepare("DELETE estan FROM estan join compite on estan.ciP=compite.ciP where idTorneo=?");
            $consulta->bind_param("i",$idTorneo);
            $consulta->execute();
            $consulta->close();
            $consulta2 = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
            $consulta3 = $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
            $consulta4= $conexion->prepare("DELETE utuliza2 FROM utiliza2 join compite on utiliza2.ciP=compite.ciP where idTorneo=?");
            $consulta4->bind_param("i",$idTorneo);
            $consulta4->execute();
            $consulta4->close();
            for($x=0;$x<count($clasificados11);$x++){ 
                $consulta2->bind_param("iii", $clasificados12[$x]->getCiP(),$pool14,$cero);
                $consulta2->execute();
                $consulta2->bind_param("iii", $clasificados11[$x]->getCiP(),$pool13,$cero);
                $consulta2->execute();
                $consulta2->bind_param("iii", $clasificados10[$x]->getCiP(),$pool14,$cero);
                $consulta2->execute();
                $consulta2->bind_param("iii", $clasificados9[$x]->getCiP(),$pool13,$cero);
                $consulta2->execute();
                $consulta3->bind_param("iii", $clasificados12[$x]->getCiP(),$kata,$tres);
                $consulta3->execute();
                $consulta3->bind_param("iii", $clasificados11[$x]->getCiP(),$kata,$tres);
                $consulta3->execute();
                $consulta3->bind_param("iii", $clasificados10[$x]->getCiP(),$kata,$tres);
                $consulta3->execute();
                $consulta3->bind_param("iii", $clasificados9[$x]->getCiP(),$kata,$tres);
                $consulta3->execute();
             
            }
            $consulta->close();
            $consulta2->close();
            $consulta3->close();
            $consulta4->close();
            $consulta5->close();
            $consulta6->close();
            $consulta7->close();
            $consulta8->close();
           }
           else{
            $clasificados4=array_slice($notas,0,4);
            $pool1=[];
            $pool2=[];
            $pool3=[];
            $uno=1;
            $dos=2;
            foreach($notas as $nota){
                echo "numero: ". $nota->getNumero();
                if($nota->getNumero()==1){
                    $pool1[]=$nota;
                }
                if($nota->getNumero()==2){
                    $pool2[]=$nota;
                }
                if($nota->getNumero()==3){
                    $pool3[]=$nota;
                }
            }
            $clasificados1=array_slice($pool1,0,4);
            $clasificados2=array_slice($pool2,0,4);
            $clasificados3=array_slice($pool3,0,4);
            $clasificadosRonda=[];
            $clasificadosRonda=array_slice($clasificados1, 0,4);
            $clasificadosRonda=array_slice($clasificados2, 0,4);
            $clasificadosRonda=array_slice($clasificados3, 0,4);
            $clasificadosRonda=array_slice($clasificados4, 0,4);
            $kata=0;
            $consulta= $conexion->prepare("DELETE estan FROM estan join compite on estan.ciP=compite.ciP where idTorneo=?");
            $consulta->bind_param("i",$idTorneo);       
            $consulta->execute();
            $consulta->close();
            $consulta2 = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
            $consulta3 = $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
            for($x=0;$x<count($clasificados1);$x++){
                $consulta2->bind_param("iii", $clasificados1[$x]->getCiP(),$poolsTiene[6],$cero);
                $consulta2->execute();
                $consulta2->bind_param("iii", $clasificados2[$x]->getCiP(),$poolsTiene[5],$cero);
                $consulta2->execute();
                $consulta2->bind_param("iii", $clasificados3[$x]->getCiP(),$poolsTiene[6],$cero);
                $consulta2->execute();
                $consulta2->bind_param("iii", $clasificados4[$x]->getCiP(),$poolsTiene[5],$cero);
                $consulta2->execute();
                $consulta3->bind_param("iii", $clasificados1[$x]->getCiP(),$kata,$dos);
                $consulta3->execute();
                $consulta3->bind_param("iii", $clasificados2[$x]->getCiP(),$kata,$dos);
                $consulta3->execute();
                $consulta3->bind_param("iii", $clasificados3[$x]->getCiP(),$kata,$dos);
                $consulta3->execute();
                $consulta3->bind_param("iii", $clasificados4[$x]->getCiP(),$kata,$dos);
                $consulta3->execute();
            }
            $consulta2->close();
            $consulta3->close();
            $consulta4 = $conexion->prepare("DELETE utiliza2 FROM utiliza2 join compite on utiliza2.ciP=compite.ciP  where idTorneo=? and ronda=?;");
            $consulta4->bind_param("ii",$idTorneo,$uno);
            $consulta4->execute();
            $consulta4->close();
        }
    }
//torneo de a 48 a 96--------------------------------------------------------------------------------------------------------
    if(count($notas)>48 && count($notas)<96){
        $clasificados8=array_slice($notas,0,4);
        $pool7=[];
        $pool6=[];
        $pool5=[];
        $pool4=[];
        $pool3=[];
        $pool2=[];
        $pool1=[];
        $uno=1;
        $dos=2; 
        foreach($notas as $nota){
            if($nota->getIdP()==1){
                $pool1[]=$nota;
            }
            if($nota->getIdP()==2){
                $pool2[]=$nota;
            }
            if($nota->getIdP()==3){
                $pool3[]=$nota;
            }
            if($nota->getIdP()==4){
                $pool4[]=$nota;
            }
            if($nota->getIdP()==5){
                $pool5[]=$nota;
            }
            if($nota->getIdP()==6){
                $pool6[]=$nota;
            }
            if($nota->getIdP()==7){
                $pool7[]=$nota;
            }
        }
        $clasificados1=array_slice($pool1,0,4);
        $clasificados2=array_slice($pool2,0,4);
        $clasificados3=array_slice($pool3,0,4);
        $clasificados4=array_slice($pool4,0,4);
        $clasificados5=array_slice($pool5,0,4);
        $clasificados6=array_slice($pool6,0,4);
        $clasificados7=array_slice($pool7,0,4);
        $clasificadosRonda=[];
        $clasificadosRonda=array_slice($clasificados1, 0,4);
        $clasificadosRonda=array_slice($clasificados2, 0,4);
        $clasificadosRonda=array_slice($clasificados3, 0,4);
        $clasificadosRonda=array_slice($clasificados4, 0,4);
        $clasificadosRonda=array_slice($clasificados5, 0,4);
        $clasificadosRonda=array_slice($clasificados6, 0,4);
        $clasificadosRonda=array_slice($clasificados7, 0,4);
        $pool12=12;
        $pool11=11;
        $pool10=10;
        $pool9=9;
        $kata=1;
        $consulta = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
        $consulta2 = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
        $consulta3 = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
        $consulta4 = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
        $consulta5 = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
        $consulta6 = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
        $consulta7 = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
        $consulta8 = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
        $consulta9= $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
        $consulta10 = $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
        $consulta11 = $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
        $consulta12= $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
        $consulta13 = $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
        $consulta14 = $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
        $consulta15= $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
        $consulta16= $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
        $consulta17= $conexion->prepare("DELETE FROM utiliza2 where ronda=?;");
        $consulta18= $conexion->prepare("DELETE FROM estan");
        $consulta18->execute();
        $consulta18->close();
        for($x=0;$x<count($clasificados1);$x++){
            $consulta->bind_param("iii", $clasificados1[$x]->getCiP(),$pool12,$cero);
            $consulta2->bind_param("iii", $clasificados2[$x]->getCiP(),$pool11,$cero);
            $consulta3->bind_param("iii", $clasificados3[$x]->getCiP(),$pool12,$cero);
            $consulta4->bind_param("iii", $clasificados4[$x]->getCiP(),$pool11,$cero);
            $consulta5->bind_param("iii", $clasificados5[$x]->getCiP(),$pool10,$cero);
            $consulta6->bind_param("iii", $clasificados6[$x]->getCiP(),$pool9,$cero);
            $consulta7->bind_param("iii", $clasificados7[$x]->getCiP(),$pool10,$cero);
            $consulta8->bind_param("iii", $clasificados8[$x]->getCiP(),$pool9,$cero);
            
            $consulta9->bind_param("iii",  $clasificados1[$x]->getCiP(),$kata,$dos);
            $consulta10->bind_param("iii", $clasificados2[$x]->getCiP(),$kata,$dos);
            $consulta11->bind_param("iii", $clasificados3[$x]->getCiP(),$kata,$dos);
            $consulta12->bind_param("iii", $clasificados4[$x]->getCiP(),$kata,$dos);
            $consulta13->bind_param("iii", $clasificados5[$x]->getCiP(),$kata,$dos);
            $consulta14->bind_param("iii", $clasificados6[$x]->getCiP(),$kata,$dos);
            $consulta15->bind_param("iii", $clasificados7[$x]->getCiP(),$kata,$dos);
            $consulta16->bind_param("iii", $clasificados8[$x]->getCiP(),$kata,$dos); 
            
            $consulta->execute();
            $consulta2->execute();
            $consulta3->execute();
            $consulta4->execute();
            $consulta5->execute();
            $consulta6->execute();
            $consulta7->execute();
            $consulta8->execute();
            $consulta9->execute();
            $consulta10->execute();
            $consulta11->execute();
            $consulta12->execute();
            $consulta13->execute();
            $consulta14->execute();
            $consulta15->execute();
            $consulta16->execute();
        }
        $consulta->close();
        $consulta2->close();
        $consulta3->close();
        $consulta4->close();
        $consulta5->close();
        $consulta6->close();
        $consulta7->close();
        $consulta8->close();
        
        $consulta9->close();
        $consulta10->close();
        $consulta11->close();
        $consulta12->close();
        $consulta13->close();
        $consulta14->close();
        $consulta15->close();
        $consulta16->close();
        
        $consulta17->bind_param("i",$uno);
        $consulta17->execute();
        $consulta17->close();
    }
    
}

public function devolverNota($ci){
    $consulta = "SELECT * FROM estan";
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $resultado = mysqli_query($conexion, $consulta);
        if (!$conexion) {
            die('Error en la conexión: ' . mysqli_connect_error());
        }
        if (!$resultado){
            die('Error en la consulta SQL: ' . $consulta);
            }
        while($fila = $resultado->fetch_assoc()){
            if($fila['ciP']==$ci){
                return $fila['notaFinal'];
            }
        }
}

public function notasTorneo($idTorneo){
    $cis=[];
    $notas=[];
    $conexion= mysqli_connect(SERVIDOR,USUARIO,PASS,BD);
    $consulta = $conexion->prepare("select estan.ciP from estan join tiene on estan.idP=tiene.idP where tiene.idT=? order by estan.idP DESC,notaFinal DESC;");
    $consulta-> bind_param("i",$idTorneo);
    $consulta-> execute();
    $resultado = $consulta->get_result();
    while ($fila = $resultado->fetch_assoc()){
        $cis[]= $fila['ciP']; 
    } 
    foreach($cis as $ci){
        foreach($this->_notas as $nota){
            if($ci==$nota->getCiP()){
                $notas[]=$nota;
            }
        }
    }
    $consulta->close();
    return $notas;
}
public function mostrarGanadores($idTorneo){
$conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
$consulta2 = $conexion->prepare("SELECT compite.ciP as 'Ci participante',Concat(participante.nombreP, ' ',participante.apellidoP) as nombre,compite.cinturon as cinturon,compite.puesto from compite join participante on compite.ciP=participante.ciP where idTorneo=? and puesto in ('1ro','2do','3ro')
order by  CASE
WHEN puesto = '1ro' THEN 1
WHEN puesto = '2do' THEN 2
WHEN puesto = '3ro' THEN 3
ELSE 4
END;");    
            $consulta2->bind_param("i",$idTorneo);
            $consulta2->execute();
            $resultado=$consulta2->get_result();
            if (!$resultado){
                die('Error en la consulta SQL: ' . $consulta);
            }
            echo "<table border='2'>";
            echo "<tr> <td> Ci participante </td> <td> Nombre </td><td> Cinturon </td><td> Puesto</td></tr> ";
            while($fila = $resultado->fetch_assoc()){
                echo "<tr> <td>".$fila['Ci participante'] . " </td><td>" . $fila['nombre'] ."</td><td>".$fila['cinturon']."</td><td>".$fila['puesto'] ."</td> </tr>"; 
            }
            echo "</table>";
}
}
?>