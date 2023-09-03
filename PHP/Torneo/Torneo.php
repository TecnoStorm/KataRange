<?php
class Torneo{
    private $_idTorneo;
    private $_fecha;
    private $_categoria;
    private $_cantParticipantes;
    private $_estado;
    private $_Parakarate;
    private $_sexo;
    private $_nombre;
    private $_direccion;

    public function __construct($id,$fecha,$categoria,$cant,$estado,$Parakarate,$sexo,$nombre,$direccion){
        $this->_idTorneo=$id;
        $this->_fecha=$fecha;
        $this->_categoria=$categoria;
        $this->_cantParticipantes=$cant;
        $this->_estado=$estado;
        $this->_paraKarate=$Parakarate;
        $this->_sexo=$sexo;
        $this->_nombre=$nombre;
        $this->_direccion=$direccion;
    }

    public function getCategoria(){
        return $this->_categoria;
    }

    public function setCategoria($categoria){
        $this->_categoria=$categoria;
    }

    public function getFecha(){
        return $this->_fecha;
    }

    public function setFecha($fecha){
        $this->_fecha=$fecha;
    }

    public function getIdTorneo(){
        return $this->_idTorneo;
    }

    public function setIdTorneo($idTorneo){
        $this->_idTorneo=$idTorneo;
    }

    public function getCantParticipantes(){
        return $this->_cantParticipantes;
    }

    public function setCantParticipates($cantidad){
        $this->_cantParticipantes=$cantidad;
    }
    
    public function getEstado(){
        return $this->_estado;
    }

    public function setEstado($estado){
        $this->_estado=$estado;
    }
    
    public function getParaKarate(){
        return $this->_paraKarate;
    }

    public function setParaKarate($Parakarate){
        $this->_paraKarate=$Parakarate;
    }
    public function getSexo(){
        return $this->_sexo;
    }

    public function setSexo($sexo){
        $this->_sexo=$sexo;
    }

    public function getNombre(){
        return $this->_nombre;
    }

    public function setNombre($nombre){
        $this->_nombre=$nombre;
    }

    public function getDireccion(){
        return $this->_direccion;
    }

    public function setDireccion($direccion){
        $this->_direccion=$direccion;
    }



public function __toString(){
    return "<tr><td>". $this->_idTorneo . "</td> <td>" . $this->_fecha . "</td> <td>" . $this->_categoria . "</td> <td>" . $this->_cantParticipantes . "</td> <td>" . $this->_estado . "</td> <td>" . $this->_paraKarate . "</td> <td>". $this->_sexo ."</td> <td>". $this->_nombre . "</td> <td>" . $this->_direccion . "</td> </tr>";
}
    
}
?>