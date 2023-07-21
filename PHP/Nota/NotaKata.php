<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/Kata/NotaKata.css">
    <title>Document</title>
</head>
<body>
<?php
include "../Participante/ParticipanteArray.php";
$participanteArray=new ParticipanteArray();
echo "<h1> Puntuacion de Kata </h1>";
echo "<table border='1'>
<tr><td> Nombre </td><td> Apellido </td><td> CI </td><td> Sexo </td><td> Categoria </td><td> IdKata </td></tr>";
$participanteArray->listar();
echo "</table>";
echo "<form action='../Puntaje.php' method='post'>";
echo "<input type='number', name='ci', placeholder='ci'>";
echo "<input type='number', name='puntaje', placeholder='Puntaje' min='5' max='10' step='0.1'> ";
echo "<input type='submit', name='enviar' value='Puntuar' id='enviar'> ";
echo "</form>";
?> 
 
</body>
</html>
