<?php
require_once ('Nota.php');
require_once ("C:/xampp/htdocs/ProgramaPhp/PHP/config.php");
require_once("C:/xampp/htdocs/ProgramaPhp/PHP/Pool/PoolArray.php");
require_once ("C:/xampp/htdocs/ProgramaPhp/PHP/Torneo/TorneoArray.php");
require_once ("C:/xampp/htdocs/ProgramaPhp/PHP/Participante/ParticipanteArray.php");
class NotaArray{
    private $_notas=array();
    public function __construct(){
        $consulta = "SELECT * FROM estan ORDER by idP desc, notaFinal DESC";
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $resultado = mysqli_query($conexion, $consulta);
        if (!$conexion) {
            die('Error en la conexión: ' . mysqli_connect_error());
        }
        if (!$resultado){
            die('Error en la consulta SQL: ' . $consulta);
            }
        while($fila = $resultado->fetch_assoc()){
            $this->_notas[]= new Nota($fila['ciP'],$fila['idP'],$fila['notaFinal'],$fila['Clasificados']);
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
    
    public function ganadores(){
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $notas=$this->_notas;
        $pools=new PoolArray();
        $cantRondas=$pools->cantRondas();
        $participantes=new ParticipanteArray();
        $cantParticipantes=$participantes->cantParticipantesTorneo();
        $pools->cantPools();
        $torneos=new TorneoArray();
        $existePuesto=$torneos->puestos();
        $consulta = $conexion ->prepare("UPDATE compite SET puesto = ?  WHERE ciP=? ;"); 
        if(count($this->_notas)==3){
            for($x=0;$x<count($notas);$x++){
                $puesto=1+$x;
                $consulta->bind_param("ii", $puesto, $notas[$x]->getCiP());
                $consulta->execute();
            }
            $consulta->close();
            $consulta2 = "SELECT * FROM compite";        
            $resultado = mysqli_query($conexion, $consulta2); 
            if (!$resultado){
                die('Error en la consulta SQL: ' . $consulta);
            }
            echo "<table border='2'>";
            echo "<tr> <td> ci participante </td> <td> puesto</td></tr> ";
            while($fila = $resultado->fetch_assoc()){
                echo "<tr> <td>".$fila['ciP'] . " </td><td>" . $fila['puesto'] . "</td> </tr>";
            }
            echo "</table>";
        }
        if(count($this->_notas)==4){
            $tercero=3;
            $posicionTercero=0; 
            $existe=false;
            $clasificados[]=$this->_notas[0];
            $clasificados[]=$this->_notas[2];
            var_dump($clasificados);
            for($x=0;$x<count($this->_notas);$x++){ 
                if($this->_notas[$x]->getIdP()==3 && $this->_notas[$x]->getNotaFinal()!=0){
                    $existe=true;
                }
            }
            if($existe){
                $consulta3 = $conexion ->prepare("UPDATE compite SET puesto = ?  WHERE ciP=? ;"); 
                $consulta4 = $conexion ->prepare("UPDATE compite SET puesto = ?  WHERE ciP=? ;"); 
                $contador=0; 
                foreach($this->_notas as $clave => $nota){ 
                    if($nota->getIdP()==3){
                        $posicion=$clave+1;
                        $consulta3->bind_param("ii",$posicion,$nota->getCiP()); 
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
                            $consulta3 = $conexion ->prepare("UPDATE compite SET puesto = ?  WHERE ciP=? ;"); 
                            $consulta3->bind_param("ii", $tercero,$nota->getCiP());
                            $consulta3->execute();
                            }    
                        }
                            
                } 
                    if($existePuesto){
                        $quinto=5;
                        $cero=0;
                        $consulta4->bind_param("ii",$tercero,$this->_notas[$posicionTercero]->getCiP());
                        echo $this->_notas[$posicionTercero]->getCiP(); 
                        $consulta4->execute();
                        $consulta4->close();
                        $consulta6=$conexion->prepare("UPDATE compite SET puesto=? WHERE puesto=? ;");
                        $consulta6->bind_param("ii",$quinto,$cero);
                        $consulta6->execute();
                        $consulta6->close();
                    } 
                }
                else{
                    $consulta3->close();
                    $consulta5 = "SELECT * FROM compite ORDER BY puesto asc ";        
                    $resultado = mysqli_query($conexion, $consulta5); 
                    if (!$resultado){
                        die('Error en la consulta SQL: ' . $consulta);
                    }
                    echo "<table border='2'>";
                    echo "<tr> <td> ci participante </td> <td> puesto</td></tr> ";
                    while($fila = $resultado->fetch_assoc()){
                        echo "<tr> <td>".$fila['ciP'] . " </td><td>" . $fila['puesto'] . "</td> </tr>";
                    }
                    echo "</table>";
                    $nota0=0; 
                    $pool=3;
                    $consulta = $conexion ->prepare("INSERT INTO  estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
                    for($x=0;$x<2;$x++){
                        $consulta2=$conexion->prepare("DELETE FROM estan where ciP=?");
                        $consulta2->bind_param("i", $clasificados[$x]->getCiP());
                        $consulta2->execute();
                        $consulta2->close();
                        $consulta->bind_param("iiis",$clasificados[$x]->getCiP(),$pool,$nota0,$clasificados[$x]->getClasificados());
                        $consulta->execute();
                    }
                    $consulta->close();
                    $conexion->close();
                }
                echo "siguiente ronda";
                echo "<a href='NotaKata.php'> Volver </a>";
            }

        if(count($this->_notas)==5){
            $existe=false;
            $tercero=3;
            $clasificados[]=$this->_notas[0];
            $clasificados[]=$this->_notas[2]; 
            $consulta3 = $conexion ->prepare("UPDATE compite SET puesto = ?  WHERE ciP=? ;");
            $consulta3->bind_param("ii",$tercero,$this->_notas[3]->getCiP()); 
            $consulta3->execute();
            $consulta3->close();
            $consulta5=$conexion->prepare("DELETE FROM estan WHERE ciP= ?");
            $consulta5->bind_param("i",$this->_notas[3]->getCiP());
            $consulta5->execute();
            $consulta5->close();
            for($x=0;$x<count($this->_notas);$x++){ 
                if($this->_notas[$x]->getIdP()==3 && $this->_notas[$x]->getNotaFinal()!=0){
                    $existe=true;
                }
            }
            $nota0=0; 
            $pool=3;
            $consulta = $conexion ->prepare("INSERT INTO  estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
            for($x=0;$x<2;$x++){
                $consulta2=$conexion->prepare("DELETE FROM estan where ciP=?");
                $consulta2->bind_param("i", $clasificados[$x]->getCiP());
                $consulta2->execute();
                $consulta2->close();
                $consulta->bind_param("iiis",$clasificados[$x]->getCiP(),$pool,$nota0,$clasificados[$x]->getClasificados());
                $consulta->execute();
            }
            $consulta->close();
            $conexion->close();
            echo "siguiente ronda";
            echo "<a href='NotaKata.php'> Volver </a>";
        }
        if(count($this->_notas)>5 && count($this->_notas)<=10){
                if($cantRondas==4){
                $clasificados16=[];
                $clasificados15=[];
                $pool15 = [];
                foreach ($this->_notas as $nota) {
                    if ($nota->getIdP() == 15) { 
                        $pool15[]=$nota;
                    }  
                }  
                $clasificados16=array_slice($this->_notas,0,3);
                $clasificados15=array_slice($pool15,0,3);   
                $consulta = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
                $consulta2 = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
                $consulta3 = $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
                $consulta4 = $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
                $posicion = 0;
                $cinco=5;
                $uno=1;
                $contador = 19;
                $contador2 = 19;
                $cero = 0;
                $consulta5 = $conexion->prepare("DELETE FROM utiliza2");
                $consulta5->execute();
                $consulta5->close();
                $consulta6= $conexion->prepare("DELETE FROM estan");
                $consulta6->execute();
                $consulta6->close();
                for($x=0;$x<count($clasificados16);$x++){ 
                    $consulta->bind_param("iii", $clasificados16[$x]->getCiP(),$contador, $cero);
                    $consulta3->bind_param("iii",$clasificados16[$x]->getCiP(),$uno,$cinco);
                    $sucess=$consulta->execute();
                    if(!$sucess){
                        echo "error: ". $consulta->error;
                    }
                    $consulta3->execute(); 
                    $contador--; 
                }
                
                for($x=0;$x<count($clasificados15);$x++){ 
                    if ($x == 1) {
                        $posicion = 2;
                    } elseif ($x == 2) {
                        $posicion = 1;
                    }

                    $consulta2->bind_param("iii",$clasificados15[$posicion]->getCiP(),$contador2, $cero); 
                    $consulta4->bind_param("iii",$clasificados15[$x]->getCiP(),$uno,$cinco);
                    $consulta2->execute();
                    $consulta4->execute();
                    $contador2--;    
                }
                $consulta->close(); 
                $consulta2->close();
                $consulta4->close();
            }else{
                if($cantRondas==3){
                    $clasificados8=[];
                    $clasificados7=[];
                    $pool7 = [];
                    foreach ($this->_notas as $nota) {
                        if ($nota->getIdP() == 7) { 
                            $pool7[]=$nota;
                        }  
                    }  
                    $clasificados8=array_slice($this->_notas,0,3);
                    $clasificados7=array_slice($pool7,0,3); 
                    var_dump($pool7);    
                    $consulta = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
                    $consulta2 = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
                    $consulta3 = $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
                    $consulta4 = $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
                    $posicion = 0;
                    $cuatro=4;
                    $uno=1;
                    $contador = 11;
                    $contador2 = 11;
                    $cero = 0;
                    $consulta5 = $conexion->prepare("DELETE FROM utiliza2");
                    $consulta5->execute();
                    $consulta5->close();
                    $consulta6= $conexion->prepare("DELETE FROM estan");
                    $consulta6->execute();
                    $consulta6->close();
                    for($x=0;$x<count($clasificados8);$x++){ 
                        $consulta->bind_param("iii", $clasificados8[$x]->getCiP(),$contador, $cero);
                        $consulta3->bind_param("iii",$clasificados8[$x]->getCiP(),$uno,$cuatro);
                        $sucess=$consulta->execute();
                        if(!$sucess){
                            echo "error: ". $consulta->error;
                        }
                        $consulta3->execute(); 
                        $contador--; 
                    }
                    
                    for($x=0;$x<count($clasificados7);$x++){ 
                        if ($x == 1) {
                            $posicion = 2;
                        } elseif ($x == 2) {
                            $posicion = 1;
                        }
    
                        $consulta2->bind_param("iii",$clasificados7[$posicion]->getCiP(),$contador2, $cero); 
                        $consulta4->bind_param("iii",$clasificados7[$x]->getCiP(),$uno,$cuatro);
                        $consulta2->execute();
                        $consulta4->execute();
                        $contador2--;    
                    }
                    $consulta->close(); 
                    $consulta2->close();
                    $consulta4->close();
                }
                else{
                    if($this->_notas[0]->getIdP()==4){  
                        $contador = 7;
                        $contador2 = 7;
                        $consulta = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
                        $consulta2 = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
                        $cero = 0;
                        $clasificados4=[];
                        $clasificados3=[];
                        $posicion=0;
                        $clasificados4 = array_slice($this->_notas, 0, 3);
                        $pool3=[];
                        foreach($this->_notas as $nota){
                            if($nota->getIdP()==3){
                                array_push($pool3,$nota);
                            }
                        }
                        $clasificados3=array_slice($pool3,0,3);
                        var_dump($clasificados3);
                        echo "<h1> el otroo eeee </h1>";
                        var_dump($clasificados4);
                        $consulta3 = $conexion->prepare("DELETE FROM estan");
                        $consulta3->execute(); 
                        $consulta3->close();
                        for($x=1;$x<=count($clasificados4);$x++){
                            $consulta->bind_param("iii", $clasificados4[$x-1]->getCiP(),$contador, $cero); 
                            $success1 = $consulta->execute();
                            if (!$success1) {
                                echo "Error en consulta 1: " . $consulta->error;
                            }
                            $contador--;
                        }
                        $consulta->close();
                        for($x=0;$x<count($clasificados3);$x++){
                            if ($x == 1) {
                                $posicion = 2;
                            } elseif ($x == 2) {
                                $posicion = 1;
                            }
                            $consulta2->bind_param("iii",$clasificados3[$posicion]->getCiP(),$contador2, $cero); 
                            $consulta2->execute();
                            $contador2--;    
                        }
                        $consulta2->close();
                    }
                 
                    else{
                        if($cantRondas==4 && $cantParticipantes>24 && $cantParticipantes<49 ||$cantRondas==5 && $cantParticipantes>48 && $cantParticipantes<97 ){
                            $contador=1;
                            $consulta = $conexion ->prepare("UPDATE compite SET puesto = ?  WHERE ciP=? ;");
                            $tercero=3;
                            for($x=0;$x<2;$x++){
                                $consulta->bind_param("ii", $contador, $this->_notas[$x]->getCiP());
                                $consulta->execute();
                                $contador++;
                            }
                            $posicion3=$this->ganadorPool($this->_notas[2]->getIdP());
                            $posicion32=$this->ganadorPool($this->_notas[4]->getIdP());
                            $consulta->close();
                            $consulta2 = $conexion->prepare("UPDATE compite SET puesto = ?  WHERE ciP=?;");
                            $consulta3 = $conexion->prepare("UPDATE compite SET puesto = ?  WHERE ciP=?");
                            $consulta2->bind_param("ii", $tercero, $this->_notas[$posicion3]->getCiP());
                            $consulta3->bind_param("ii", $tercero, $this->_notas[$posicion32]->getCiP());
                            $consulta2->execute();
                            $consulta2->close();
                            $consulta3->execute();
                            $consulta3->close();
                              
                        }
                        else{ 
                            foreach ($this->_notas as $nota) {
                                if ($nota->getIdP() == 1) {
                                    $pool1[] = $nota;
                                } else {
                                    $pool2[] = $nota;
                                }
                            }
                            
                            $clasificados1=[];
                            $clasificados2=[];
                            $pool1 = [];
                            $pool2 = [];
                            $clasificados1=array_slice($pool1,0,3);
                            $clasificados2=array_slice($pool2,0,3) ;               
                            $consulta = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
                            $consulta2 = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
                            $consulta3 = $conexion->prepare("DELETE FROM estan");
                            $consulta3->execute(); 
                            $consulta3->close(); 
                            $posicion = 0;
                            $contador = 3;
                            $contador2 = 3;
                            $cero = 0;
            
                            for($x=0;$x<count($clasificados1);$x++){ 
                                $consulta->bind_param("iii", $clasificados1[$x]->getCiP(),$contador, $cero);
                                $consulta->execute(); 
                                $contador++;
                            }
            
                            for($x=0;$x<count($clasificados2);$x++){
                                if ($x == 1) {
                                    $posicion = 2;
                                } elseif ($x == 2) {
                                    $posicion = 1;
                                }
            
                                $consulta2->bind_param("iii",$clasificados2[$posicion]->getCiP(),$contador2, $cero); 
                                $consulta2->execute();
                                $contador2++;    
                            }
                            $consulta->close(); 
                            $consulta2->close();
                            $conexion->close();
                        } 
                    }
                }
            } 
            }


    if(count($this->_notas)>10 && count($this->_notas) <=24){
        if($cantRondas==3){
            $clasificados14=[];
            $clasificados13=[];
            $dos=2;
            $cuatro=4;
            $uno=1;
            $clasificados14 = array_slice($this->_notas, 0, 4);
            $pool13 = [];
            $pool15 = 15;
            $pool16 = 16;
            $posicion=0;
            $consulta = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
            $consulta2 = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
            $consulta3 = $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
            $consulta4 = $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
            $consulta5= $conexion->prepare("DELETE FROM utiliza2");
            $consulta5->execute();
            $consulta5->close();
            foreach($this->_notas as $nota){
                if($nota->getIdP()==13){
                    array_push($pool13,$nota);
                }
            }
            $clasificados13=array_slice($pool13,0,4);
            echo "<h1>hola</h1>";
            $consulta6= $conexion->prepare("DELETE FROM estan");
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
                $clasificados6 = array_slice($this->_notas, 0, 4);
                $pool5 = [];
                $pool7 = 7;
                $pool8 = 8;
                $posicion=0;
                $consulta = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
                $consulta2 = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
                $consulta3 = $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
                $consulta4 = $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
                $consulta5= $conexion->prepare("DELETE FROM utiliza2");
                $consulta5->execute();
                $consulta5->close(); 
                foreach($this->_notas as $nota){
                    if($nota->getIdP()==5){
                        array_push($pool5,$nota);
                    }
                }
                $clasificados5=array_slice($pool5,0,4);
                $consulta6= $conexion->prepare("DELETE FROM estan");
                $consulta6->execute();
                $consulta6->close();
                echo "<h1>hola</h1>";
                for($x=0;$x<count($clasificados6);$x++){
                    $consulta->bind_param("iii",$clasificados5[$x]->getCiP(),$pool7,$cero);
                    $consulta2->bind_param("iii",$clasificados6[$x]->getCiP(),$pool8,$cero);
                    $consulta3->bind_param("iii",$clasificados5[$x]->getCiP(),$uno,$tres); 
                    $consulta4->bind_param("iii",$clasificados6[$x]->getCiP(),$uno,$tres);
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
                $clasificados1 = [];
                $clasificados2 = array_slice($this->_notas, 0, 4);
                $pool1 = [];
                $pool3 = 3;
                $pool4 = 4;
                $posicion=0;
                $consulta = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
                $consulta2 = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
                foreach($this->_notas as $nota){
                    if($nota->getIdP()==1){
                        array_push($pool1,$nota);
                    }
                }
                $clasificados1=array_slice($pool1,0,4);
                $consulta3 = $conexion->prepare("DELETE FROM estan");
                $consulta3->execute(); 
                $consulta3->close(); 
                echo "<h1>hola</h1>";
                for($x=0;$x<count($clasificados1);$x++){
                    $consulta->bind_param("iii",$clasificados1[$x]->getCiP(),$pool3,$cero);
                    $consulta2->bind_param("iii",$clasificados2[$x]->getCiP(),$pool4,$cero);
                    $consulta->execute();
                    $consulta2->execute();
                }
                $consulta->close();
                $consulta2->close();
            }
        }
       
    }    
    
        if(count($this->_notas)>24 && count($this->_notas) <49){
           if($cantRondas==2){
            $clasificados12=array_slice($this->_notas,0,4);
            $pool11=[];
            $pool10=[];
            $pool9=[];
            $uno=1;
            $tres=3;
            foreach($this->_notas as $nota){
                if($nota->getIdP()==11){
                    $pool11[]=$nota;
                }
                if($nota->getIdP()==10){
                    $pool10[]=$nota;
                }
                if($nota->getIdP()==9){
                    $pool9[]=$nota;
                }
            }
            $clasificados11=array_slice($pool11,0,4);
            $clasificados10=array_slice($pool10,0,4);
            $clasificados9=array_slice($pool9,0,4);
            $pool13=13;
            $pool14=14;
            $kata=1;  
            $consulta9= $conexion->prepare("DELETE FROM estan");
            $consulta9->execute();
            $consulta9->close();
            $consulta = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
            $consulta2 = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
            $consulta3 = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
            $consulta4 = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
            $consulta5 = $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
            $consulta6 = $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
            $consulta7 = $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
            $consulta8 = $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
            $consulta10= $conexion->prepare("DELETE FROM utiliza2");
            $consulta10->execute();
            $consulta10->close();
            for($x=0;$x<count($clasificados11);$x++){ 
                $consulta->bind_param("iii", $clasificados12[$x]->getCiP(),$pool14,$cero);
                $consulta2->bind_param("iii", $clasificados11[$x]->getCiP(),$pool13,$cero);
                $consulta3->bind_param("iii", $clasificados10[$x]->getCiP(),$pool14,$cero);
                $consulta4->bind_param("iii", $clasificados9[$x]->getCiP(),$pool13,$cero);

                $consulta5->bind_param("iii", $clasificados12[$x]->getCiP(),$kata,$tres);
                $consulta6->bind_param("iii", $clasificados11[$x]->getCiP(),$kata,$tres);
                $consulta7->bind_param("iii", $clasificados10[$x]->getCiP(),$kata,$tres);
                $consulta8->bind_param("iii", $clasificados9[$x]->getCiP(),$kata,$tres);
                $consulta->execute();
                $consulta2->execute();
                $consulta3->execute();
                $consulta4->execute();
                $consulta5->execute();
                $consulta6->execute();
                $consulta7->execute();
                $consulta8->execute();
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
            $clasificados4=array_slice($this->_notas,0,4);
            $pool1=[];
            $pool2=[];
            $pool3=[];
            $uno=1;
            $dos=2;
            foreach($this->_notas as $nota){
                if($nota->getIdP()==1){
                    $pool1[]=$nota;
                }
                if($nota->getIdP()==2){
                    $pool2[]=$nota;
                }
                if($nota->getIdP()==3){
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
            $pool5=5;
            $pool6=6;
            $kata=1;
            $consulta9= $conexion->prepare("DELETE FROM estan");
            $consulta9->execute();
            $consulta9->close();
            $consulta = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
            $consulta2 = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
            $consulta3 = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
            $consulta4 = $conexion->prepare("INSERT INTO estan (ciP,idP,notaFinal) VALUES (?,?,?);");
            $consulta5 = $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
            $consulta6 = $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
            $consulta7 = $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
            $consulta8 = $conexion->prepare("INSERT INTO utiliza2 (ciP,idKata,ronda) VALUES (?,?,?);");
            $consulta10= $conexion->prepare("DELETE FROM utiliza2 where ronda=?;");
            for($x=0;$x<count($clasificados1);$x++){
                $consulta->bind_param("iii", $clasificados1[$x]->getCiP(),$pool5,$cero);
                $consulta2->bind_param("iii", $clasificados2[$x]->getCiP(),$pool6,$cero);
                $consulta3->bind_param("iii", $clasificados3[$x]->getCiP(),$pool5,$cero);
                $consulta4->bind_param("iii", $clasificados4[$x]->getCiP(),$pool6,$cero);
                $consulta5->bind_param("iii", $clasificados1[$x]->getCiP(),$kata,$dos);
                $consulta6->bind_param("iii", $clasificados2[$x]->getCiP(),$kata,$dos);
                $consulta7->bind_param("iii", $clasificados3[$x]->getCiP(),$kata,$dos);
                $consulta8->bind_param("iii", $clasificados4[$x]->getCiP(),$kata,$dos);
                $consulta->execute();
                $consulta2->execute();
                $consulta3->execute();
                $consulta4->execute();
                $consulta5->execute();
                $consulta6->execute();
                $consulta7->execute();
                $consulta8->execute();
            }
            $consulta->close();
            $consulta2->close();
            $consulta3->close();
            $consulta4->close();
            $consulta5->close();
            $consulta6->close();
            $consulta7->close();
            $consulta8->close();
            $consulta10->bind_param("i",$uno);
            $consulta10->execute();
            $consulta10->close();
        }
            
    }

    if(count($this->_notas)>48 && count($this->_notas)<96){
        $clasificados8=array_slice($this->_notas,0,4);
        $pool7=[];
        $pool6=[];
        $pool5=[];
        $pool4=[];
        $pool3=[];
        $pool2=[];
        $pool1=[];
        $uno=1;
        $dos=2; 
        foreach($this->_notas as $nota){
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
}
?>