<?php
class Escuela{
private $_nombre;
private $_id;
private $_tecnica;
public function __construct($id,$tecnica,$nombre){
$this->_id=$id;
$this->_tecnica=$tecnica;
$this->_nombre=$nombre;
}
public function getid(){
    return $this->_id;
}
public function setid($id){
    $this->_id=$id;
}

public function getTecnica(){
    return $this->_tecnica;
}
public function setTecnica($tecnica){
    $this->_tecnica=$tecnica;
}

public function getnombre(){
    return $this->_nombre;
}
public function setNombre($nombre){
    $this->_nombre=$nombre;
}
}

?>