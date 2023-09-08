<?php
require_once("../Torneo/TorneoArray.php");
require_once("../Pool/PoolArray.php");
$nombre=$_POST['nombreTorneo'];
$torneos=new TorneoArray();
$pools=new PoolArray();
$torneo=$torneos->infoTorneo($nombre);
$ids=$pools->idsPool();
for($x=0;$x<count($ids);$x++){
 $existe=$pools->poolTorneos($torneo->getIdTorneo(),$ids[$x]);
}
if($existe){
    echo "<p style='color:#EDAD14'>pools ya ingresados</p>";
}
else{
    echo "<p style='color:green'> pool guardados correctamente </p>";
}
?>