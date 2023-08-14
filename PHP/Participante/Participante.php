<?php
class Participante{
    private $_nombre;
    private $_apellido;
    private $_ci;
    private $_sexo;
    private $_categoria;
    private $_idKata;
    private $_condicion;
    public function __construct($nombre, $apellido,$ci,$sexo,$condicicion,$categoria,$idKata){
        $this->_nombre=$nombre;
        $this->_apellido=$apellido;
        $this->_ci=$ci;
        $this->_sexo=$sexo;
        $this->_categoria=$categoria;
        $this->_idKata=$idKata;
        $this->_condicion=$condicicion;
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
    public function getCondicion(){
        return $this->_condicion;
    }

    public function setPool($condicicion){
        $this->_condicion=$condicion;
    }
 
    public function __toString(){
        return "<tr><td>".$this->_nombre."</td><td>".$this->_apellido."</td><td>".$this->_ci."</td><td>".$this->_sexo."</td><td>".$this->_categoria ."</td> <td>". $this->_condicion. "</td> </tr>";
    }
}
?>