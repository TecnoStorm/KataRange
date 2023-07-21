<?php
require_once("Kata.php")
class KataArray{
    private $_katas;

    public function __construct(){
        $archivo = fopen("katas.txt","r");
        while(!feof($archivo)) {
            $linea = fgets($archivo, 256);
            $valores = explode(":", $linea);
            $this->_katas[] = new Kata($valores[0], $valores[1]);
        }
    } 
}
?>