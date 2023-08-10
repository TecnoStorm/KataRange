<?php
class Kata{
    private $_idKata;
    private $_nombre;
    public function construct($idKata, $nombre){
        $this->_idKata=$kata;
        $this->_nombre=$nombre;
    }

    public function getIdKata(){
        return $this->_idKata;
    }

    public function setIdKata($id){
        $this->_idKata=$id;
    }

    public function getNombre(){
        return $this->_nombre;
    }

    public function setNombre($nombre){
        $this->_nombre=$nombre
    }
    
    public function __toString(){
        return "<td><td>".$this->_nombre. "</td><td>" .$this->_idKata."</td></tr>";
    }
}
?>