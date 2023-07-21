<?php
require_once ('Nota.php');
class NotaArray{
    private $_notas=array();
    public function __construct(){
        $archivo = fopen("C:/xampp/htdocs/ProgramaPhp/TXT/NotasFinales.txt","r");
        while(!feof($archivo)) {
            $linea = fgets($archivo, 256);
            if($linea!=""){
                $valores = explode(":", $linea);
                $this->_notas[] = new Nota($valores[0], $valores[1], $valores[2],$valores[3]);
            }
        }
    }

    public function guardar(){
        $archivo = fopen("C:/xampp/htdocs/ProgramaPhp/TXT/NotasFinales.txt","w");
        foreach ($this->_notas as $nota){
            $linea = implode(":", (array)$nota);
            fwrite($archivo, $linea);
        }
        fclose($archivo);
    }

    public function ponerNota($ci,$nombre,$apellido,$notaFinal){  
        $nota= new Nota(PHP_EOL .$ci,$nombre, $apellido,$notaFinal); 
        array_push($this->_notas,$nota);
    }

    public function listar(){
        foreach ($this->_notas as $nota){
            echo $nota;
        }
    }   
    
    public function cantNotas(){
        return count($this->_notas);
   }

    public function posicionGanador(){
        $mejorPuntaje=0;
        $posicion=0;
        for($x=0;$x<count($this->_notas);$x++){
            if($mejorPuntaje<$this->_notas[$x]->getNotaFinal()){
                $mejorPuntaje=$this->_notas[$x]->getNotaFinal();
                $posicion=$x;
            }
        }
        return $posicion;
    }

    public function ganador($posicion){
        echo "Ganador/a" . " ". $this->_notas[$posicion];
    }

    public function ordenar() {
        $n = count($this->_notas);
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                if ($this->_notas[$j]->getNotaFinal() < $this->_notas[$j + 1]->getNotaFinal()) {
                    $temp = $this->_notas[$j];
                    $this->_notas[$j] = $this->_notas[$j + 1];
                    $this->_notas[$j + 1] = $temp;
                }
            }
        }
    }
    public function ordenarArray($array){}
    public function getArray(){
        return $this->_notas;
    }

public function resultadoCi($ci){
    $this->ordenar();
    foreach($this->_notas as $nota){
        if($nota->getCi()==$ci){
          echo $nota;
        }
    }

}

}
?>