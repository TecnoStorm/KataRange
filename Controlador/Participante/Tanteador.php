
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
$cinturon=$participantes->cinturon($ci);
echo "<section class='contenedor-ronda'><svg viewBox='0 0 1356 177' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><path fill='rgba(12, 124, 214, 1)' d='M 0 56 C 344.5 56 344.5 110 689 110 L 689 110 L 689 0 L 0 0 Z' stroke-width='0'></path> <path fill='rgba(12, 124, 214, 1)' d='M 688 110 C 1022 110 1022 56 1356 56 L 1356 56 L 1356 0 L 688 0 Z' stroke-width='0'> </path></svg>
<p> Ronda - ".$ronda.". Pool - ".$pool.". Cat - ".$participante->getCategoria().". Sexo - ". $participante->getSexo() ."</p></section>
";
echo "<p id='oculto'> $cinturon </p>";
echo "<section class='contenedor-total'><section class='contenedor'>
<section class='ContenedorNota'> ". $nota. "</section>";
echo "</section>";
echo "<section class='contenedorNombre'>".$participante->getNombre(). ", ". $participante->getApellido(). " <section class='contenedorKata'>".  $kata."</section></section></section>";
echo "<section class='botonVolver'><a href='ElegirParticipante.html' class='Traducir'> <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' fill='currentColor' class='bi bi-box-arrow-left' viewBox='0 0 16 16'>
<path fill-rule='evenodd' d='M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z'/>
<path fill-rule='evenodd' d='M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z'/>
</svg>
Volver</a>
</section>";
?>
