<?php
class Participante{
    private $_nombre;
    private $_apellido;
    private $_ci;
    private $_sexo;
    private $_categoria;
    private $_idKata;
    private $_pool;
    private $_notaFinal;
    public function __construct($nombre, $apellido,$ci,$sexo,$categoria,$idKata,$pool,$nota){
        $this->_nombre=$nombre;
        $this->_apellido=$apellido;
        $this->_ci=$ci;
        $this->_sexo=$sexo;
        $this->_categoria=$categoria;
        $this->_idKata=$idKata;
        $this->_pool=$pool;
        $this->_notaFinal=$nota;
    }

    public function getNombre(){
        return $this->_nombre;
    }

    public function setNombre($nombre){
        $this->_nombre=$nombre;
    }

    public function getApellido(){
        return $this->_apellido;
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

    public function getSexo(){                                              
        return $this->_sexo;
    }

    public function setSexo($sexo){
        $this->_sexo=$sexo;
    }
        
    public function getCategoria(){
        return $this->_categoria;
    }

    public function setCategoria($cat){
        $this->_categoria=$cat;
    }

    public function getIdKata(){
        return $this->_idKata;
    }
    
    public function setIdKata($kata){
        $this->_idKata=$kata;
    }
    public function getPool(){
        return $this->_pool;
    }

    public function setPool($pool){
        $this->_pool=$pool;
    }
 
    public function getNota(){
        return $this->_notaFinal;
    }

    public function setNota($nota){
        $this->_notaFinal=$nota;
    }
    public function __toString(){
        return "<tr><td>".$this->_nombre."</td><td>".$this->_apellido."</td><td>".$this->_ci."</td><td>".$this->_sexo."</td><td>".$this->_categoria ."</td><td>" .$this->_idKata . "</td> </tr>";
    }
}
?>