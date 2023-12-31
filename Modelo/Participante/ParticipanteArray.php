<?php
require_once("Participante.php");
require_once (__DIR__."/../Nota/NotaArray.php"); 
require_once (__DIR__."/../../Controlador/config.php");
require_once (__DIR__."/../Pool/PoolArray.php");
class ParticipanteArray{
    private $_participantes=array();    
    public function __construct(){
        $consulta = "SELECT * FROM participante";
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $resultado = mysqli_query($conexion, $consulta);
        if (!$conexion) {
            die('Error en la conexión: ' . mysqli_connect_error());
        }
        if (!$resultado){
            die('Error en la consulta SQL: ' . $consulta);
            }
        while($fila = $resultado->fetch_assoc()){
        $this->_participantes[]= new Participante($fila['nombreP'],$fila['apellidoP'],$fila['ciP'],$fila['sexo'],$fila['condicion'],$fila['categoriaP']);
    }
    }
    
    public function guardar($nombre, $apellido,$ci,$sexo,$condicion,$categoria){
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        if (!$conexion) {
            die('Error en la conexión: ' . mysqli_connect_error());
        }
        $consulta = $conexion ->prepare(
            "INSERT INTO persona (ci,nombre,apellido)
            values (?,?,?)");
        
        $consulta2 = $conexion ->prepare(
         "INSERT INTO participante (nombreP,apellidoP,ciP,sexo,condicion,categoriaP) values (?,?,?,?,?,?)");
        $consulta->bind_param("iss", $ci, $nombre, $apellido);
        $success=$consulta->execute();
        if(!$success){
            echo  "Participante ya registrado";
        }
        else{
            $consulta->close();
            $consulta2->bind_param("ssisss", $nombre, $apellido,$ci,$sexo,$condicion,$categoria);
            $consulta2->execute();
            $consulta2->close();
            $conexion->close();
            echo "<p style='color: green;'> participant entered correctly </p>";
        }
    }

    public function ponerParticipante($nombre, $apellido,$ci,$sexo,$categoria,$idKata,$pool,$nota){  
        $participante= new Participante(PHP_EOL. $nombre, $apellido,$ci,$sexo,$categoria,$idKata,$pool,$nota); 
        array_push($this->_participantes,$participante);
    }
    
    public function listar(){
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $consulta = "SELECT * FROM participante";
        $resultado = mysqli_query($conexion, $consulta);
        if (!$resultado){
            die('Error en la consulta SQL: ' . $consulta);
        }
        echo "<section class='contenedorTabla'>";
        echo "<table><thead>";
        echo "<tr> <th class='Traducir'> Nombre </th> <th class='Traducir'> Apellido </th> <th> CI participante </th> </th><th class='Traducir'> Sexo </th> <th class='Traducir'> Condicion </th><th class='Traducir'> Categoria </th> </tr></thead><tbody>";
        
        while($fila = $resultado->fetch_assoc()){
            echo "<tr> <td>".$fila['nombreP'] . " </td><td>" . $fila['apellidoP'] . "</td><td>  " . $fila['ciP'] . "</td> <td class='Traducir'>" . $fila['sexo'] . "</td><td class='Traducir'>" . $fila ['condicion'] . " </td><td class='Traducir'>" . $fila ['categoriaP']. "</td> </tr>";
        }
        
        echo "</tbody></table>
        </section>";
    }
    
    public function eliminarParticipante($ci){
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $existe=$this->ExisteParticipante($ci);
        $existeenPool=$this->ExisteParticipanteenPool($ci);
        if($existe){
            if($existeenPool){
                echo "<p style='color:#EDAD14'> el participante pertenece a un pool</p>";
            }
            else{
                $consulta = $conexion ->prepare("DELETE FROM estudia WHERE ciP=?");
                $consulta2 = $conexion ->prepare("DELETE FROM utiliza2 WHERE ciP=?");
                $consulta4=$conexion->prepare("DELETE FROM compite WHERE ciP=?");
                $consulta3 = $conexion ->prepare("DELETE FROM participante WHERE ciP=?");   
                if (!$consulta) {
                    die('Error en la consulta 1: ' . $conexion->error);
                }
                $consulta->bind_param("i", $ci);
                $consulta2->bind_param("i", $ci);
                $consulta3->bind_param("i", $ci);
                $consulta4->bind_param("i",$ci);
                $consulta->execute();
                $consulta->close();
                $consulta2->execute();
                $consulta2->close();
                $consulta4->execute();
                $consulta4->close();
                $success=$consulta3->execute();

                if(!$success){
                   echo $consulta3->error;
                }

                else{
                   echo "<p style='color:green'> participante borrado con existo </p>";
                }

                $conexion->close();
            }
        }
        else{
            echo "<p style='color:red'> no se encuentra registrado el participante</p>";
        }     
    }

    public function eliminarPersona($ci){
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $consulta2 = $conexion ->prepare("DELETE FROM persona WHERE ci=?");

        if (!$consulta2) {
            die('Error en la consulta 1: ' . $conexion->error);
        }

        $consulta2->bind_param("i", $ci);
        $consulta2->execute();
        $consulta2->close();
        $conexion->close();
    }
  
    public function comparar($ci){
        foreach ($this->_participantes as $participante) {
            if($participante->getCi()==$ci){
                return true;
            }
        }
        return false;
    }


    public function obtenerNombre($ci){
        $nombre="";
        foreach($this->_participantes as $participante){
            if($participante->getCi()==$ci){
                $nombre=$participante->getNombre();
            }    
        }
        return $nombre;
    }

    public function obtenerApellido($ci){
        $apellido="";
        foreach($this->_participantes as $par){
            if($par->getCi()==$ci){
                $apellido= $par->getApellido();
            } 
        }
        return $apellido;    
    }


    public function mostrarPool(){
        foreach($this->_participantes as $participante){
            echo  $participante->getNombre() . " " . $participante->getApellido() . " Pool:" . $participante->getPool(). "<br>";
        }
    }

    public function cantParticipantes(){
        return count($this->_participantes);
    }

    public function devolverArray(){
        return $this->_participantes;
    }

    

    public function ganadoresDeRonda($pool) {
        $posiciones = array();
        $notaArray = new NotaArray();
        $notaArray->ordenar();
        $notaArray->guardar();
        $this->ordenarParticipante();
        $this->guardar();
        if (count($this->_participantes) >=10) {
            foreach ($this->_participantes as $participante) {
                if ($participante->getPool() == $pool) {
                    $posiciones[] = $participante;   
                }
            }
            foreach ($posiciones as $key => $posicion) {
                if ($key < 4) {
                    $notaArray->resultadoCi($posicion->getCi());
                }
            }
        }
    }

    public function cambioNota($ci,$nota){
        foreach($this->_participantes as $participante){
            if($participante->getCi()==$ci){
                $participante->setNota($nota);
            }
        }
    }

    public function ordenarParticipante() {
        $n = count($this->_participantes);
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                if ($this->_participantes[$j]->getNota() < $this->_participantes[$j + 1]->getNota()) {
                    $temp = $this->_participantes[$j];
                    $this->_participantes[$j] = $this->_participantes[$j + 1];
                    $this->_participantes[$j + 1] = $temp;
                }
            }
        }
    }

    public function cantPools(){
        $contador=0;
        $pool=1;
        for($x=1;$x<count($this->_participantes);$x++){
            if($x%8==0){
                $contador++;
            }
        }
        $resultado=$contador+$pool;
        return $resultado;
    }

    public function obtenerPool($ci){
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $consulta = $conexion->prepare("SELECT idP FROM estan where Notafinal=0 and ciP=?");
        $consulta->bind_param("i",$ci);
        $consulta->execute();
        $resultado = $consulta->get_Result();
        $pool=0;
        while($fila = $resultado->fetch_assoc()){
           $pool=$fila['idP'];
        }
        return $pool;
    }

    public function notas($ciJ,$ciP,$idP,$nota){
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        if (!$conexion) {
            die('Error en la conexión: ' . mysqli_connect_error());
        }
        $consulta = $conexion ->prepare(
        "INSERT INTO puntua (ciJ,ciP,idP,Nota_Final)
        values (?,?,?,?)");
        $consulta->bind_param("iiid", $ciJ, $ciP, $idP,$nota);
        $success=$consulta->execute();
        if(!$success){
            echo "<p style='color:#EDAD14'> La nota ya ha sido ingresada </p>";
            echo $consulta->error;
        }
        else{
            echo  "<p style='color:green'> nota ingresada con exito nota ingresada </p>"; 
        }
        $consulta->close();
        $conexion->close();
    }

    public function GetParticipantes(){
        return $this->_participantes;
    }



    public function cantidadNotas($ci,$idP){
        $contador=0;
        $notas=false;
        $pools=new PoolArray();
        $idP=$pools->getIdPool($ci);
        $participante=$this->devolverInfo($ci);
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $consulta = $conexion->prepare("SELECT count(Nota_Final) 'cantidad de notas' FROM puntua where ciP=? and idP=?");
        $consulta->bind_param("ii",$ci,$idP);
        $consulta->execute();
        $resultado = $consulta->get_Result();
        while($fila = $resultado->fetch_assoc()){
            if($fila['cantidad de notas']==5){
                $notas=true;
            }
        }
        return $notas;
    }

    public function notaFinal($idPool,$ci){
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $consulta = $conexion->prepare("select * from puntua where idP=? and puntua.ciP=?");
        $consulta->bind_param("ii",$idPool,$ci);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $notas=[];
        $existe=false;
        $contador=0;
        if (!$resultado){
            die('Error en la consulta SQL: ' . $consulta);
        }
        while($fila = $resultado->fetch_assoc()){
            $notas[]=$fila['Nota_Final'];
        }
        for($x=0;$x<count($notas);$x++){
            $contador++;
            echo $contador;
        }
        $participante=$this->devolverInfo($ci);
        if($participante->getCondicion()!="Ninguna"){
           $existe=true;
        }
        if($contador==5 && !$existe || $contador==5 && $existe && isset($_SESSION['notaExtra']) ){
            $mayorPuntaje = array_search(max($notas), $notas);
            unset($notas[$mayorPuntaje]);
            $menorPuntaje = array_search(min($notas), $notas);
            unset($notas[$menorPuntaje]); 
            $notaFinal = array_sum($notas);
            $notaExtra=0;
            if(isset($_SESSION['notaExtra'])){
                $notaExtra=$_SESSION['notaExtra'];
            }
            $notaFinal+=$notaExtra;
            $consulta2 = $conexion ->prepare("UPDATE estan SET notaFinal = ?  WHERE ciP=?;");
            $consulta2->bind_param("di", $notaFinal,$ci);
            $consulta2->execute();
            $consulta2->close();
            unset($_SESSION['notaExtra']);
            $consulta3= $conexion->prepare("UPDATE utiliza2 set notaFinal=? WHERE ciP=? and notaFinal is null");
            $consulta3->bind_param("di",$notaFinal,$ci);
            $success=$consulta3->execute();
            if(!$success){
                echo $consulta3->error;
            }
            $consulta3->close();
            $conexion->close();
            echo $notaFinal . $ci;
        }
    }

    public function participanteAPuntuar($idTorneo){ 
        $notas=[];
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $consulta = $conexion->prepare("SELECT estan.* FROM estan join tiene on estan.idP=tiene.idP where idT=? ORDER BY idP;");
        $consulta->bind_param("i",$idTorneo);
        $consulta->execute();
        $resultado = $consulta->get_Result();
        while($fila = $resultado->fetch_assoc()){
            $notas[]=$fila['notaFinal'];
            
        }
        $posicion=array_search(0,$notas);
        return $posicion;   
    }

    public function existe0($idTorneo){
        $pools=new PoolArray();
        $existe=false;
        $ids=$pools->RangoPools($idTorneo);
        $notas=[];
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $consulta = $conexion->prepare("SELECT estan.* FROM estan join tiene on estan.idP=tiene.idP where idT=? ORDER BY idP;");
        $consulta->bind_param("i",$idTorneo);
        $consulta->execute();
        $resultado = $consulta->get_result();
        while($fila = $resultado->fetch_assoc()){
            $notas[]=$fila['notaFinal'];
        }
        if(in_array(0,$notas)){     
            $existe=true;
        }
        return $existe;
    }

    public function cantParticipantesTorneo($idTorneo){
        $participantes=[];
        $contador=0;
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $consulta="SELECT * FROM compite";
        $resultado = mysqli_query($conexion, $consulta);
        while($fila = $resultado->fetch_assoc()){
            if($idTorneo==$fila['idTorneo']){
               $participantes[]=$fila['ciP'];
            }
        }
        return count($participantes);
    }

    public function ExisteParticipante($ci){
        foreach($this->_participantes as $participante){
            if($participante->getCi()==$ci){
                return true;
            }
        }
        return false;
    }

    public function ExisteParticipanteenPool($ci){
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $consulta = "SELECT * FROM estan";
        $resultado = mysqli_query($conexion, $consulta);
        if (!$resultado){
            die('Error en la consulta SQL: ' . $consulta);
        }
        while($fila = $resultado->fetch_assoc()){
            if($fila['ciP']==$ci){
                return true;
            }   
            else{
                return false;
            }
        }
    }
    
public function devolverInfo($ci){
    foreach($this->_participantes as $participante){
        if($participante->getCi()==$ci){
            return $participante;
        }
    }
}
public function cinturon($ci){
    $cinturon='';
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = $conexion->prepare("select cinturon from compite join participante on compite.ciP=participante.ciP where participante.ciP=?");
    $consulta->bind_param("i",$ci);
    $consulta->execute();
    $resultado=$consulta->get_result();
    while($fila = $resultado->fetch_assoc()){
        $cinturon=$fila['cinturon'];
    }
    return $cinturon;
}
public function notasParticipante($ci,$idP){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = $conexion->prepare("select count(Nota_Final) 'cantidad de notas' from puntua where ciP=? and idP=?");
    $consulta->bind_param("ii",$ci,$idP);
    $consulta->execute();
    $cantidad=0;
    $resultado = $consulta->get_result();
    while($fila = $resultado->fetch_assoc()){
      $cantidad=$fila['cantidad de notas'];
    }
    return $cantidad;
}
}
?> 
