<?php
require_once("Participante.php");
require_once ("C:/xampp/htdocs/ProgramaPhp/PHP/Nota/NotaArray.php");
require_once ("C:/xampp/htdocs/ProgramaPhp/PHP/config.php");

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
        $this->_participantes[]= new Participante($fila['nombreP'],$fila['apellidoP'],$fila['ciP'],$fila['sexo'],$fila['condicion'],$fila['categoriaP'],$fila['idKata']);
    }
    }
    
    public function guardar($nombre, $apellido,$ci,$sexo,$condicion,$categoria,$idKata){
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        if (!$conexion) {
            die('Error en la conexión: ' . mysqli_connect_error());
        }
        $consulta = $conexion ->prepare(
            "INSERT INTO Persona (ci,nombre,apellido)
            values (?,?,?)");
        
        $consulta2 = $conexion ->prepare(
         "INSERT INTO Participante (nombreP,apellidoP,ciP,sexo,condicion,categoriaP,idKata)
         values (?,?,?,?,?,?,?)");
        $consulta->bind_param("iss", $ci, $nombre, $apellido);
        $consulta->execute();
        $consulta->close();
        $consulta2->bind_param("ssisssi", $nombre, $apellido,$ci,$sexo,$condicion,$categoria,$idKata);
        $consulta2->execute();
        $consulta2->close();
        $conexion->close();
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
echo "<table border='2'>";
echo "<tr> <td> Nombre </td> <td> apellido </td> <td> Ci </td> </td><td> sexo </td> <td> condicion </td><td> categoria </td> <td> idKata </td> </tr>";
while($fila = $resultado->fetch_assoc()){
echo "<tr> <td>".$fila['nombreP'] . " </td><td>" . $fila['apellidoP'] . "</td><td>  " . $fila['ciP'] . "</td> <td>" . $fila['sexo'] . "</td><td>" . $fila ['condicion'] . " </td><td>" . $fila ['categoriaP']. "</td><td>" . $fila ['idKata']. "</td> </tr>";
}
echo "</table>";
    }
    
    public function eliminarParticipante($ci){
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $consulta = $conexion ->prepare(
            "DELETE FROM persona WHERE ci=?");
            if (!$consulta) {
                die('Error en la consulta 1: ' . $conexion->error);
            }
         $consulta->bind_param("i", $ci);
         $consulta->execute();
         $consulta->close();
         $conexion->close();
         
    }
    public function eliminarPersona($ci){
        $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
        $consulta2 = $conexion ->prepare(
            "DELETE FROM Participante WHERE ciP=?");
            if (!$consulta2) {
                die('Error en la consulta 1: ' . $conexion->error);
            }
        $consulta2->bind_param("i", $ci);
        $consulta2->execute();
        $consulta2->close();
        $conexion->close();
    }
    public function borrarArchivo(){
        $archivo = fopen("C:/xampp/htdocs/ProgramaPhp/TXT/participantes.txt","w");
        fwrite($archivo, "");
        fclose($archivo);
    }

    public function comparar($ci){
        foreach ($this->_participantes as $participante) {
            if($participante->getCi()==$ci){
                return true;
            }
        }
        return false;
    }

    public function mostrarInfo($ci,$nota){
        foreach($this->_participantes as $participante){
            if($participante->getCi()==$ci){
                echo  "nombre:". $participante->getNombre()." Apellido: ". $participante->getApellido() . " nota final : ". $nota;
            }
        }
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

public function pool() {
    
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
public function guardarPool(){
    $archivo=fopen("C:/xampp/htdocs/ProgramaPhp/TXT/participantes.txt","w");
    foreach($this->_participantes as $participante){
        $linea= implode (":", (array)$participante) ;
        fputs($archivo,$linea);
    }
    fclose($archivo);
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
    $consulta = "SELECT * FROM estan";
    $resultado = mysqli_query($conexion, $consulta);
    $ciParticipantes=[];
    $pools=[];
    $pool;
    if (!$resultado){
        die('Error en la consulta SQL: ' . $consulta);
    }
    while($fila = $resultado->fetch_assoc()){
        $ciParticipantes[]=$fila['ciP'];
        $pools[]=$fila['idP'];
    }
    for($x=0;$x<count($ciParticipantes);$x++){
        if($ci==$ciParticipantes[$x]){
            $pool=$pools[$x];
        }
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
    $consulta->bind_param("iiii", $ciJ, $ciP, $idP,$nota);
    $consulta->execute();
    $consulta->close();
    $conexion->close();
}

public function GetParticipantes(){
    return $this->_participantes;
}

public function devolverInfo($ci){
    foreach($this->_participantes as $participante){
        if($participante->getCi()==$ci){
            echo $participante->getNombre() . " ". $participante->getApellido(); 
        }
    }
}

public function cantidadNotas($ci){
    $contador=0;
    $notas=false;
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = "SELECT * FROM puntua";
    $resultado = mysqli_query($conexion, $consulta);
    if (!$resultado){
        die('Error en la consulta SQL: ' . $consulta);
    }

    while($fila = $resultado->fetch_assoc()){
        if($ci=$fila['ciP']){
            $contador++;
        }
        if($contador>=5){
            $notas=true;
        }
    }
    return $notas;
}

public function notaFinal($ci){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = "SELECT * FROM puntua";
    $resultado = mysqli_query($conexion, $consulta);
    $notas=[];
    $contador=0;
    if (!$resultado){
    die('Error en la consulta SQL: ' . $consulta);
    }
    while($fila = $resultado->fetch_assoc()){
        $notas[]=$fila['Nota_Final'];
    }
    for($x=0;$x<count($notas);$x++){
        $contador++;
    }
    if($contador==5){
        $mayorPuntaje = array_search(max($notas), $notas);
        $menorPuntaje = array_search(min($notas), $notas);
        unset($notas[$mayorPuntaje]);
        unset($notas[$menorPuntaje]);
        $notaFinal = array_sum($notas);
        $consulta2 = $conexion ->prepare(
        "UPDATE estan SET notaFinal = ?  WHERE ciP=?;");
        $consulta2->bind_param("ii", $notaFinal,$ci);
        $consulta2->execute();
        $consulta2->close();
        $conexion->close();
        echo $notaFinal . $ci;
}
}
public function borrarNotas(){
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = $conexion ->prepare("DELETE FROM puntua;");
    $consulta->execute();
    $consulta->close();
    $conexion->close();
}
public function participanteAPuntuar(){ 
    $notas=[];
    $conexion = mysqli_connect(SERVIDOR, USUARIO,PASS,BD);
    $consulta = "SELECT * FROM estan ORDER BY notaFinal DESC";
    $resultado = mysqli_query($conexion, $consulta);
    if (!$resultado){
        die('Error en la consulta SQL: ' . $consulta);
    }

    while($fila = $resultado->fetch_assoc()){
        $notas[]=$fila['notaFinal'];
    }
    var_dump($notas);
    $posicion=array_search(0,$notas);
    echo  "posicion: ". $posicion;
    return $posicion;   
}
}
?> 
