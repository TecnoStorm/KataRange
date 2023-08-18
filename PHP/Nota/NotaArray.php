<?php
require_once ('Nota.php');
require_once ("C:/xampp/htdocs/ProgramaPhp/PHP/config.php");
require_once("C:/xampp/htdocs/ProgramaPhp/PHP/Pool/PoolArray.php");
require_once ("C:/xampp/htdocs/ProgramaPhp/PHP/Torneo/TorneoArray.php");
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

    public function ganadores(){
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $notas=$this->_notas;
        $pools=new PoolArray();
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
    }

}
?>