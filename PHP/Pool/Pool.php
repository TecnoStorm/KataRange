<?php
class Pool{
private $_estado;
private $_horaInicio;
private $_idP; 
private $_horaFinal;
public function __construct($estado, $horaInicio,$idP,$horaFinal){
    $this->_estado=$estado;
    $this->_horaInicio=$horaInicio;
    $this->_idP=$idP;
    $this->_horaFinal=$horaFinal;
}

public function getEstado(){
    return $this->_estado;
}
public function setEstado($estado){
    $this->_estado=$estado;
}

public function getHoraInicio(){
    return $this->_horaInicio;
}
public function setHoraInicio($horaInicio){
    $this->_horaInicio=$horaInicio;
}

public function getIdP(){
    return $this->_idP;
}
public function setIdP($idP){
    $this->_idP=$idP;
}    

public function getHoraFinal(){
    return $this->_horaFinal;
}
public function setHoraFinal($horaFinal){
    $this->_horaFinal=$horaFinal;
}

public function __toString(){
    return "<tr><td>". $this->_estado. "</td> <td>" . $this->_horaInicio. "</td><td>" . $this->_idP . "</td> <td>" . $this->_HoraFinal . "</td> </tr>";
}
}


?>