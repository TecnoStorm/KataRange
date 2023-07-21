<?php
class Nota{
    private $_ci;
    private $_nombre;
    private $_apellido;
    private $_notaFinal;

    public function __construct($ci,$nombre, $apellido,$notaFinal){
        $this->_ci=$ci;
        $this->_nombre=$nombre;
        $this->_apellido=$apellido;
        $this->_notaFinal=$notaFinal;
    }

    public function getCi(){
        return $this->_ci;
    }

    public function setCi($ci){
        $this->_ci=$ci;
    }

    public function getNombre(){
        return $this->_nombre;
    }

    public function setNombre($nombre){
        $this->_nombre=$nombre;
    }

    public function setApellido($apellido){
        $this->_apellido=$apellido;
    }

    public function getApellido(){
        return $this->_apellido;
    }

    public function getNotaFinal(){
        return $this->_notaFinal;
    }
    public function setNotaFinal($nota){
        return $this->_notaFinal=$nota;
    }

    public function __toString(){
        return "<tr><td>". $this->_nombre . "</td> <td>". $this->_apellido . "</td> <td>" . $this->_notaFinal . "</td></tr>";
    }




}
?>    