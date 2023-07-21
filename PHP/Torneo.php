<?php
require_once ("Participante.php")
class Torneo{
    private $_fecha;
    private $_categoria;
    private $_idTorneo;
    private $_cantParticipantes;
    private $_individualEquipo;
    private $_participantes=array();
    private $_jueces=array();

    public function __construct($fecha,$categoria,$id,$cant,$individual,$participantes,$jueces){
        $this->_fecha=$fecha;
        $this->_categoria=$categoria;
        $this->_idTorneo=$id;
        $this->_cantParticipantes=$cant;
        $this->_individualEquipo=$individual;
        $this->_participantes=$participaciones;
        $this->_jueces=$jueces;
    }

    public function ponerParticipante($nombre, $apellido,$ci,$fechaNac,$sexo,$celular){
        $participante=new Participante($nombre, $apellido,$ci,$fechaNac,$sexo,$celular);
        array_push($this->_participantes,$participante);
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

    public function setCategoria($cantidad){
        $this->_cantParticipantes=$cantidad;
    }

    public function getIndividualEquipo(){
        return $this->_individualEquipo;
    }
    
    public function setIndividualEquipo($individualEquipo){
        $this->_individualEquipo=$individualEquipo;
    }

    public function guardarParticipantes(){
        $archivo=$fopen("Participantes.txt" "w");
        foreach($this->_participantes as $participante){
            $linea= implode(":", (array)$participante).PHP_EOL;
            $fwrite($archivo,$linea);
        }
        fclose($archivo);
    }

    public function guardarJueces(){
        $archivo=$fopen("Jueces.txt" "w");
        foreach($this->_jueces as $juez){
            $linea= implode(":", (array)$juez).PHP_EOL;
            $fwrite($archivo,$linea);
        }
        fclose($archivo);
    }

    public function ponerJueces($nombre, $apellido,$ci,$fechaNac,$sexo,$celular,$numero){
        $juez=new Juez($nombre, $apellido,$ci,$fechaNac,$sexo,$celular,$numero);
        array_push($this->_jueces,$juez);
    }
    
}
?>