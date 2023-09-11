<?php
include "../../Modelo/Torneo/TorneoArray.php";
$id=$_POST["id"];
$estado=$_POST['estado'];
$puesto="null";
$cinturon="null";
$torneos=new TorneoArray();
$existeTorneo=$torneos->existeTorneo($id);
if($existeTorneo){
    $existe=$torneos->mismoEstado($estado,$id);
    if($existe){
        echo "<p style='color: #EDAD14';> el torneo ya esta ". $estado. "</p>";
    }
    else{
        $torneos->cambiarEstado($id,$estado);
        echo "<p style='color: green';> el torneo ahora esta: ".$estado ;
    }
}
else{
    echo "<p style='color: red';> no existe el torneo </p>";   
}


?>