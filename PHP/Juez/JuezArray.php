<?php
require_once("Juez.php");
class JuezArray{
    private $_jueces; 
    public function __construct(){
        $archivo = fopen("../../TXT/jueces.txt","r");
        while(!feof($archivo)){
            $linea = fgets($archivo, 256);
            $valores = explode(":", $linea);
            $this->_jueces[] = new Juez($valores[0], $valores[1], $valores[2],$valores[3]);
        }
    }

    public function guardar(){
        $archivo = fopen("../../TXT/jueces.txt","w");
        foreach ($this->_jueces as $juez){
            $linea = implode(":", (array)$juez);
            fwrite($archivo, $linea);
        }
        fclose($archivo);
    }

    public function ponerJuez($nombre, $apellido,$ci,$clave){  
        $juez= new Juez(PHP_EOL .$nombre, $apellido,$ci,$clave); 
        array_push($this->_jueces,$juez);
    }
    
    public function listar(){
        foreach ($this->_jueces as $juez){
            echo $juez;
        }
    }
    public function comparar($nombre, $clave){
        foreach ($this->_jueces as $usuario) {
            if($usuario->getNombre()==$nombre && $usuario->getClave()==$clave){
                return true;
            }
        }
        return false;
    }
} 


?>