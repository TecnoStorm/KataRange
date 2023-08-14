<?php
include "PoolArray.php";
session_start();
$pools=new PoolArray();
$pools->AsignarPool();
$pools->MostrarAsignados(); 
$_SESSION['pools']=serialize($pools);
?>