<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../../Vista/CSS/Participante/Participantes.css">
</head>
<body>
  <?php 
require_once ("../../Modelo/Participante/ParticipanteArray.php");
require_once ("../../Modelo/Escuela/EscuelaArray.php");
$torneos=new TorneoArray();
$escuelas=new EscuelaArray();
$nombresTorneo=$torneos->nombresTorneo();
$nombres=$escuelas->nombresEscuela();
echo "<section id='registrar'>
        <h2> Registrar Participantes</h2>
        <form id='registrarParticipante'>
        <section class='registrar-contenedor'>
          <section class='registrar1'>
            <input type='number' name='ci' placeholder='CI' id='ci'>
            <input type='text' name='nombre' placeholder='Nombre' id='nombre'>
            <input type='text' name='apellido' placeholder='Apellido' id='apellido'>
          </section>
        <section class='registrar1'>
          <select name='categoria' id='categoria'> Categoria
              <option value='12/13'>12/13</option>
              <option value='14,15'>14/15</option>
              <option value='16/17'>16/17</option>
              <option value='mayores'>Mayores</option>
          </select>
            <input type='number' placeholder='Id kata' min='1' max='102' name='idKata' class='opcion2' id='idKata'>
            <select name='sexo' id='sexo'>
            <option value='Masculino'>Masculino</option>
            <option value='Femenino'>Femenino</option>
          </select>
          <select name='Condicion' id='Condicion'>
            <option value='Ninguna'>Ninguna</option>
            <option value='K10'> K10</option>
            <option value='K21'> K21</option>
            <option value='K22'> K22</option>
            <option value='K30'> K30</option>
          </select>
        </section>
      </section>
  <select name='nombreEscuela'>";
       foreach($nombres as $nombre){
              echo "<option value='$nombre'> $nombre </option>";
       }
       echo "</select>;
       <select name='nombreTorneo'>";
       foreach($nombresTorneo as $nombre){
              echo "<option value='$nombre'> $nombre </option>";
       }
echo  "</select>
       <section class='boton-registrar'>
  <input type='submit' name='registrar' value='Registrar' class='btnregistrar'>
  <h2>Mostrar participantes</h2>
   <a href='Mostrar.php'> Mostrar</a>
   </section>
    </form>
 <h2> Registrar escuela</h2>
 <form id='formularioEscuela'>
  <input type='text' name='nombreEscuela' id='nombreEscuela' placeholder='Nombre de la escuela'>
  <input type='text' name='tecnica' id='nombreEscuela' placeholder='Técnica que enseña'>
  <section class='boton-registrar'>
 <input type='submit' name='registrarEscuela' value='Registrar' class='btnregistrar'>
 </section>
 </form>
 <p id='mensajeEscuela'></p>
   <p id='mensaje'></p>
   <p id='mensajeBorrar'></p>
   </section>
   </section>
 <h2> Torneos disponibles </h2>";
$torneos->mostrar();
echo   "<section id='borrar'>
   <h2>Borrar participante</h2>
   <form id='FormularioBorrar'>
   <input type='number' name='ciBorrar' placeholder='CI' id='ciBorrar'>
   <section class='boton-registrar'>
   <input type='submit' name='Borrar' value='Borrar' class='btnregistrar'>
   </section>
   </form>
   </section>
   <section id='salir'>
   <a href='../../index.php'> 
   <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' fill='currentColor' class='bi bi-box-arrow-left' viewBox='0 0 16 16'>
       <path fill-rule='evenodd' d='M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z'/>
       <path fill-rule='evenodd' d='M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z'/>
     </svg>
     Volver</a>
   </section>";
?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js%22%3E"></script>
  <script src="../../Controlador/js/RegistrarEscuela.js"> </script>
  <script src="../../Controlador/js/RegistrarParticipante.js"></script>
  <script src="../../Controlador/js/Borrar.js"> </script>
</body>

</html>