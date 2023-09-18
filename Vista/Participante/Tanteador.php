<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Vista/CSS/Participante/Tanteador.css">
    <link rel="stylesheet" href="../CSS/Idioma.css">
    <title>Document</title>
</head>
<body> 
<section id='contenedorIdioma'>
<p>Español</p>
<input type="checkbox" id="idioma">
<p>Ingles</p>
</section>    
<?php
require_once("../../Modelo/Participante/ParticipanteArray.php");
require_once("../../Modelo/Pool/PoolArray.php");
require_once("../../Modelo/Kata/KataArray.php");
require_once("../../Modelo/Nota/NotaArray.php");
$ci=$_POST['ciParticipante'];
$participantes=new ParticipanteArray();
$pools=new PoolArray();
$katas=new KataArray();
$notas=new NotaArray();
$nota=$notas->devolverNota($ci);
$valores=$katas->devolverInfo($ci);
$idkata=$valores[0];
$ronda=$valores[1];
$kata=$katas->devolverNombre($idkata);
$pool=$pools->DevolverPool($ci);
$participante=$participantes->devolverInfo($ci);

echo "<section>".
"<p class='Traducir'> nombre: ". $participante->getNombre(). " Apellido:". $participante->getApellido(). " Categoria: ".$participante->getCategoria()." ronda: ".$ronda." pool: ".$pool." kata: ".$kata.".nota:". $nota. "</p>";
echo "<a href='../Juez/opcionesJuez.php' class='Traducir'>    <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' fill='currentColor' class='bi bi-box-arrow-left' viewBox='0 0 16 16'>
<path fill-rule='evenodd' d='M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z'/>
<path fill-rule='evenodd' d='M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z'/>
</svg>
Volver</a>
</section>";
?>
<script src="../../Controlador/js/Traduccion.js"> </script>
</body>
</html>