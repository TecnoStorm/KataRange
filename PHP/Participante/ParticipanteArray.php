<?php
require_once("Participante.php");
require_once "C:/xampp/htdocs/ProgramaPhp/PHP/Nota/NotaArray.php";
class ParticipanteArray{
    private $_participantes=array();
    public function __construct(){
        $archivo = fopen("C:/xampp/htdocs/ProgramaPhp/TXT/participantes.txt","r");
        while(!feof($archivo)) {
            $linea = fgets($archivo, 256);
            if($linea!= ""){
                $valores = explode(":", $linea);
                $this->_participantes[] = new Participante($valores[0], $valores[1], $valores[2], $valores[3], $valores[4], $valores[5],$valores[6],$valores[7]);
            }
        }
    }
    public function guardar(){
        $archivo = fopen("C:/xampp/htdocs/ProgramaPhp/TXT/participantes.txt","w");
        foreach ($this->_participantes as $participante){
            $linea = implode(":", (array)$participante);
            fwrite($archivo, $linea);
        }
        fclose($archivo);
    }

    public function ponerParticipante($nombre, $apellido,$ci,$sexo,$categoria,$idKata,$pool,$nota){  
        $participante= new Participante(PHP_EOL. $nombre, $apellido,$ci,$sexo,$categoria,$idKata,$pool,$nota); 
        array_push($this->_participantes,$participante);
    }
    
    public function listar(){
        foreach ($this->_participantes as $participante){
            echo $participante;
        }
    }
    
    public function eliminarParticipante($ci){
        foreach($this->_participantes as $clave => $participante){   
            if($this->_participantes[$clave]->getCi()==$ci){ 
                unset($this->_participantes[$clave]);
            }
        }   
        $this->borrarArchivo();
        $this->guardar();
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
    if (count($this->_participantes) < 3) {
        echo "el torneo se realizará a partir de 3 participantes";
        return;
    }

    if (count($this->_participantes) == 3) {
        shuffle($this->_participantes);
        foreach ($this->_participantes as $participante) {
            $participante->setPool(1);
        }
    } elseif (count($this->_participantes) == 4) {
        shuffle($this->_participantes);
        $this->_participantes[0]->setPool(1); 
        $this->_participantes[1]->setPool(1);
        $this->_participantes[2]->setPool(2);
        $this->_participantes[3]->setPool(2); 
    } elseif (count($this->_participantes) == 5) {
        shuffle($this->_participantes);
        $this->_participantes[0]->setPool(1); 
        $this->_participantes[1]->setPool(1);
        $this->_participantes[2]->setPool(1);
        $this->_participantes[3]->setPool(2);  
        $this->_participantes[4]->setPool(2); 
    } elseif (count($this->_participantes) > 5 && count($this->_participantes) <= 10) {
        shuffle($this->_participantes);
        $cantParticipantesAo = count($this->_participantes) / 2;
        for ($x = 0; $x < $cantParticipantesAo; $x++) {
            $this->_participantes[$x]->setPool(1);
        }
        for ($x = count($this->_participantes) - 1; $x >= count($this->_participantes) / 2; $x--) {
            $this->_participantes[$x]->setPool(2);
        }
    } elseif (count($this->_participantes) > 10) {
        shuffle($this->_participantes);
        for ($x = 0; $x < count($this->_participantes); $x++) {
            $this->_participantes[$x]->setPool(1);
            if ($x >= 8 && $x < 16) {
                $this->_participantes[$x]->setPool(2);
            }
            if ($x >= 16 && $x < 24) {
                $this->_participantes[$x]->setPool(3);
            }
            if ($x >= 24 && $x < 32) {
                $this->_participantes[$x]->setPool(4);
            }
        }
    }
}

public function mostrarPool(){
    foreach($this->_participantes as $participante){
        echo  $participante->getNombre() . " " . $participante->getApellido() . " Pool:" . $participante->getPool(). "<br>";
    }

}

public function cantParticipantes(){
    return count($this->_participantes);
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
    if (count($this->_participantes) > 10) {
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
    for($x=1;$x<count($this->_participantes);$x++){
        if($contador<$this->_participantes[$x]->getPool()){
            $contador=$this->_participantes[$x]->getPool();
        }
    }
return $contador;   
}

}

?> 
