<?php
class Nota{
    private $_ciP;
    private $_idP;
    private $_notaFinal;
    private $_Clasificados;
    private $_numero;

    public function __construct($ciP,$idP, $notaFinal,$Clasificados,$numero){
        $this->_ciP=$ciP;
        $this->_idP=$idP;
        $this->_notaFinal=$notaFinal;
        $this->_Clasificados=$Clasificados;
        $this->_numero=$numero;

    }

    public function getCiP(){
        return $this->_ciP;
    }

    public function setCiP($ci){
        $this->_ciP=$ci; 
    }


    public function getIdP(){
        return $this->_idP;
    }

    public function setIdP($idP){
        $this->_idP=$idP;
    }

    public function getNotaFinal(){
        return $this->_notaFinal;
    }

    public function setNotaFinal($notaFinal){
        $this->_notaFinal=$notaFinal;
    }

    public function getClasificados(){
        return $this->_Clasificados;
    }
    public function setClasificados($Clasificados){
        return $this->_Clasificados=$Clasificados;
    }

    public function getNumero(){
        return $this->_numero;
    }

    public function setNumero($numero){
        $this->_numero=$numero; 
    }

    public function __toString(){
        return "<tr><td>". $this->_ciP . "</td> <td>". $this->_idP . "</td> <td>" . $this->_notaFinal . "</td><td>". $this->_Clasificados . "</td> </tr>";
    }
}
?>    