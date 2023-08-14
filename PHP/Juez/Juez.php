<?php
class Juez{
    private $_nombre;
    private $_apellido;
    private $_usuario;
    private $_ci;
    private $_clave;
    public function __construct($nombre,$apellido,$usuario,$ci,$clave){
        $this->_nombre=$nombre;
        $this->_apellido=$apellido;
        $this->_usuario=$usuario;
        $this->_ci=$ci;
        $this->_clave=$clave;
    }

    public function getNombre(){
        return $this->_nombre;
    }

    public function setNombre($nombre){
        $this->_nombre=$nombre;
    }

    public function getApellido(){
        return $this->_nombre;
    }

    public function setApellido($apellido){
        $this->_apellido=$apellido;
    }

    public function getCi(){
        return $this->_ci;
    }

    public function setCi($ci){
        $this->_ci=$ci;
    }

    public function getClave(){
        return $this->_clave;
    }

    public function setClave($clave){
        $this->_clave=$clave;
    }
    
    public function getUsuario(){
        return $this->_usuario;
    }

    public function setUsuario($usuario){
        $this->_usuario=$usuario;
    }
    public function __toString(){
        return "<tr><td>".$this->_nombre."</td><td>".$this->_apellido."</td><td>".$this->_usuario. "</td><td>".$this->_ci."</td></tr>";
    }
}
?>