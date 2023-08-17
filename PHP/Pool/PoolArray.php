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
    public function CrearPool(){
        $participantes=new ParticipanteArray();
        $arrayParticipantes= (array) $participantes->devolverArray();
        $id=1;
        $estado="cerrado";
        $horaInicio="null";
        $horaFinal="null";
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        if (!$conexion) {
            die('Error en la conexión: ' . mysqli_connect_error());
        }
        $consulta = $conexion ->prepare(
        "INSERT INTO Pool (estado,hora_inicio,idP,hora_final) values (?,?,?,?)");
        $consulta->bind_param("ssis", $estado, $horaInicio, $id,$horaFinal);
        $consulta->execute();
        if(count($arrayParticipantes)==4){
            $pool2=2;
            $consulta->bind_param("ssis", $estado, $horaInicio,$pool2,$horaFinal);
            $consulta->execute();
            }
       
        else{       
        for($x=1;$x<=count($arrayParticipantes);$x++){
            if($x%8==0){
                $id++;
                $consulta->bind_param("ssis", $estado, $horaInicio, $id,$horaFinal);
                $consulta->execute();
            }
        }
        $consulta->close();
        $conexion->close();
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

    public function AsignarPool(){
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $torneos=new TorneoArray();
        $participantesMismaCategoria=$torneos->mismaCategoria();
        $ciParticipantes=$torneos->ciParticipantesTorneoPools(); 
        var_dump($ciParticipantes); 
        $participantes=new ParticipanteArray();
        $participantesArray=$participantes->devolverArray();
        $id=1;
        $notaFinal="null";
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
                $consulta->bind_param("iiis", $ciParticipantes[$x],$id,$notaFinal,$clasificados);
                $consulta->execute();
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
        } elseif (count($participantesMismaCategoria) > 10) {
            $consulta = $conexion ->prepare(
            "INSERT INTO estan (ciP,idP,notaFinal,Clasificados) values (?,?,?,?)");
            for($x=1;$x<=count($participantesMismaCategoria);$x++){ 
                $consulta->bind_param("iiis", $ciParticipantes[$x-1],$id,$notaFinal,$clasificados); 
                $consulta->execute();
                if($x%8==0){
                    $id++;
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
} 
?>